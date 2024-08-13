<?php

namespace PHPMaker2021\ppejp_web;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class Register extends WUsers
{
    use MessagesTrait;

    // Page ID
    public $PageID = "register";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "Register";

    // Rendering View
    public $RenderingView = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl()
    {
        $url = ScriptName() . "?";
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Custom template
        $this->UseCustomTemplate = true;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (w_users)
        if (!isset($GLOBALS["w_users"]) || get_class($GLOBALS["w_users"]) == PROJECT_NAMESPACE . "w_users") {
            $GLOBALS["w_users"] = &$this;
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;
        if (Post("customexport") === null) {
             // Page Unload event
            if (method_exists($this, "pageUnload")) {
                $this->pageUnload();
            }

            // Global Page Unloaded event (in userfn*.php)
            Page_Unloaded();
        }

        // Export
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => $url];
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['user_id'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
    }

    // Lookup data
    public function lookup()
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal")) {
            $searchValue = Post("sv", "");
            $pageSize = Post("recperpage", 10);
            $offset = Post("start", 0);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = Param("q", "");
            $pageSize = Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
            $start = Param("start", -1);
            $start = is_numeric($start) ? (int)$start : -1;
            $page = Param("page", -1);
            $page = is_numeric($page) ? (int)$page : -1;
            $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        }
        $userSelect = Decrypt(Post("s", ""));
        $userFilter = Decrypt(Post("f", ""));
        $userOrderBy = Decrypt(Post("o", ""));
        $keys = Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        $lookup->toJson($this); // Use settings from current page
    }
    public $FormClassName = "ew-horizontal ew-form ew-register-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $UserTable, $CurrentLanguage, $Breadcrumb, $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-register-form ew-horizontal";

        // Set up Breadcrumb
        $Breadcrumb = new Breadcrumb("index");
        $Breadcrumb->add("register", "RegisterPage", CurrentUrl(), "", "", true);
        $this->Heading = $Language->phrase("RegisterPage");
        $userExists = false;
        $this->loadRowValues(); // Load default values

        // Get action
        $action = "";
        if (IsApi()) {
            $action = "insert";
        } elseif (Post("action") != "") {
            $action = Post("action");
        }

        // Check action
        if ($action != "") {
            // Get action
            $this->CurrentAction = $action;
            $this->loadFormValues(); // Get form values

            // Validate form
            if (!$this->validateForm()) {
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        } else {
            $this->CurrentAction = "show"; // Display blank record
        }

        // Insert record
        if ($this->isInsert()) {
            // Check for duplicate User ID
            $filter = GetUserFilter(Config("LOGIN_USERNAME_FIELD_NAME"), $this->user_email->CurrentValue);
            // Set up filter (WHERE Clause)
            $this->CurrentFilter = $filter;
            $userSql = $this->getCurrentSql();
            $rs = Conn($UserTable->Dbid)->executeQuery($userSql);
            if ($rs->fetch()) {
                $userExists = true;
                $this->restoreFormValues(); // Restore form values
                $this->setFailureMessage($Language->phrase("UserExists")); // Set user exist message
            }
            if (!$userExists) {
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow()) { // Add record
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("RegisterSuccess")); // Register success
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate("login"); // Return
                        return;
                    }
                } else {
                    $this->restoreFormValues(); // Restore form values
                }
            }
        }

        // API request, return
        if (IsApi()) {
            $this->terminate();
            return;
        }

        // Render row
        $this->RowType = ROWTYPE_ADD; // Render add
        $this->resetAttributes();
        $this->renderRow();

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Pass table and field properties to client side
            $this->toClientVar(["tableCaption"], ["caption", "Visible", "Required", "IsInvalid", "Raw"]);

            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }
        }
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->user_id->CurrentValue = null;
        $this->user_id->OldValue = $this->user_id->CurrentValue;
        $this->user_email->CurrentValue = null;
        $this->user_email->OldValue = $this->user_email->CurrentValue;
        $this->no_hp->CurrentValue = null;
        $this->no_hp->OldValue = $this->no_hp->CurrentValue;
        $this->pass->CurrentValue = null;
        $this->pass->OldValue = $this->pass->CurrentValue;
        $this->_userlevel->CurrentValue = 0;
        $this->aktif->CurrentValue = null;
        $this->aktif->OldValue = $this->aktif->CurrentValue;
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->user_created_by->CurrentValue = null;
        $this->user_created_by->OldValue = $this->user_created_by->CurrentValue;
        $this->updated_at->CurrentValue = null;
        $this->updated_at->OldValue = $this->updated_at->CurrentValue;
        $this->user_updated_by->CurrentValue = null;
        $this->user_updated_by->OldValue = $this->user_updated_by->CurrentValue;
        $this->nama_peserta->CurrentValue = null;
        $this->nama_peserta->OldValue = $this->nama_peserta->CurrentValue;
        $this->perusahaan->CurrentValue = null;
        $this->perusahaan->OldValue = $this->perusahaan->CurrentValue;
        $this->jabatan->CurrentValue = null;
        $this->jabatan->OldValue = $this->jabatan->CurrentValue;
        $this->provinsi->CurrentValue = null;
        $this->provinsi->OldValue = $this->provinsi->CurrentValue;
        $this->kota->CurrentValue = null;
        $this->kota->OldValue = $this->kota->CurrentValue;
        $this->usaha->CurrentValue = null;
        $this->usaha->OldValue = $this->usaha->CurrentValue;
        $this->produk->CurrentValue = null;
        $this->produk->OldValue = $this->produk->CurrentValue;
        $this->last_login->CurrentValue = null;
        $this->last_login->OldValue = $this->last_login->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'user_id' first before field var 'x_user_id'
        $val = $CurrentForm->hasValue("user_id") ? $CurrentForm->getValue("user_id") : $CurrentForm->getValue("x_user_id");

        // Check field name 'user_email' first before field var 'x_user_email'
        $val = $CurrentForm->hasValue("user_email") ? $CurrentForm->getValue("user_email") : $CurrentForm->getValue("x_user_email");
        if (!$this->user_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->user_email->Visible = false; // Disable update for API request
            } else {
                $this->user_email->setFormValue($val);
            }
        }

        // Check field name 'no_hp' first before field var 'x_no_hp'
        $val = $CurrentForm->hasValue("no_hp") ? $CurrentForm->getValue("no_hp") : $CurrentForm->getValue("x_no_hp");
        if (!$this->no_hp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->no_hp->Visible = false; // Disable update for API request
            } else {
                $this->no_hp->setFormValue($val);
            }
        }

        // Check field name 'pass' first before field var 'x_pass'
        $val = $CurrentForm->hasValue("pass") ? $CurrentForm->getValue("pass") : $CurrentForm->getValue("x_pass");
        if (!$this->pass->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pass->Visible = false; // Disable update for API request
            } else {
                $this->pass->setFormValue($val);
            }
        }

        // Note: ConfirmValue will be compared with FormValue
        if (Config("ENCRYPTED_PASSWORD")) { // Encrypted password, use raw value
            $this->pass->ConfirmValue = $CurrentForm->getValue("c_pass");
        } else {
            $this->pass->ConfirmValue = RemoveXss($CurrentForm->getValue("c_pass"));
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->user_email->CurrentValue = $this->user_email->FormValue;
        $this->no_hp->CurrentValue = $this->no_hp->FormValue;
        $this->pass->CurrentValue = $this->pass->FormValue;
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssoc($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }

        // Call Row Selected event
        $this->rowSelected($row);
        if (!$rs) {
            return;
        }
        $this->user_id->setDbValue($row['user_id']);
        $this->user_email->setDbValue($row['user_email']);
        $this->no_hp->setDbValue($row['no_hp']);
        $this->pass->setDbValue($row['pass']);
        $this->_userlevel->setDbValue($row['userlevel']);
        $this->aktif->setDbValue($row['aktif']);
        $this->created_at->setDbValue($row['created_at']);
        $this->user_created_by->setDbValue($row['user_created_by']);
        $this->updated_at->setDbValue($row['updated_at']);
        $this->user_updated_by->setDbValue($row['user_updated_by']);
        $this->nama_peserta->setDbValue($row['nama_peserta']);
        $this->perusahaan->setDbValue($row['perusahaan']);
        $this->jabatan->setDbValue($row['jabatan']);
        $this->provinsi->setDbValue($row['provinsi']);
        $this->kota->setDbValue($row['kota']);
        $this->usaha->setDbValue($row['usaha']);
        $this->produk->setDbValue($row['produk']);
        $this->last_login->setDbValue($row['last_login']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['user_id'] = $this->user_id->CurrentValue;
        $row['user_email'] = $this->user_email->CurrentValue;
        $row['no_hp'] = $this->no_hp->CurrentValue;
        $row['pass'] = $this->pass->CurrentValue;
        $row['userlevel'] = $this->_userlevel->CurrentValue;
        $row['aktif'] = $this->aktif->CurrentValue;
        $row['created_at'] = $this->created_at->CurrentValue;
        $row['user_created_by'] = $this->user_created_by->CurrentValue;
        $row['updated_at'] = $this->updated_at->CurrentValue;
        $row['user_updated_by'] = $this->user_updated_by->CurrentValue;
        $row['nama_peserta'] = $this->nama_peserta->CurrentValue;
        $row['perusahaan'] = $this->perusahaan->CurrentValue;
        $row['jabatan'] = $this->jabatan->CurrentValue;
        $row['provinsi'] = $this->provinsi->CurrentValue;
        $row['kota'] = $this->kota->CurrentValue;
        $row['usaha'] = $this->usaha->CurrentValue;
        $row['produk'] = $this->produk->CurrentValue;
        $row['last_login'] = $this->last_login->CurrentValue;
        return $row;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // user_id

        // user_email

        // no_hp

        // pass

        // userlevel

        // aktif

        // created_at

        // user_created_by

        // updated_at

        // user_updated_by

        // nama_peserta

        // perusahaan

        // jabatan

        // provinsi

        // kota

        // usaha

        // produk

        // last_login
        if ($this->RowType == ROWTYPE_VIEW) {
            // user_id
            $this->user_id->ViewValue = $this->user_id->CurrentValue;
            $this->user_id->ViewCustomAttributes = "";

            // user_email
            $this->user_email->ViewValue = $this->user_email->CurrentValue;
            $this->user_email->ViewCustomAttributes = "";

            // no_hp
            $this->no_hp->ViewValue = $this->no_hp->CurrentValue;
            $this->no_hp->ViewCustomAttributes = "";

            // pass
            $curVal = trim(strval($this->pass->CurrentValue));
            if ($curVal != "") {
                $this->pass->ViewValue = $this->pass->lookupCacheOption($curVal);
                if ($this->pass->ViewValue === null) { // Lookup from database
                    $filterWrk = "`userlevelid`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->pass->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->pass->Lookup->renderViewRow($rswrk[0]);
                        $this->pass->ViewValue = $this->pass->displayValue($arwrk);
                    } else {
                        $this->pass->ViewValue = $this->pass->CurrentValue;
                    }
                }
            } else {
                $this->pass->ViewValue = null;
            }
            $this->pass->ViewCustomAttributes = "";

            // userlevel
            if ($Security->canAdmin()) { // System admin
                $curVal = trim(strval($this->_userlevel->CurrentValue));
                if ($curVal != "") {
                    $this->_userlevel->ViewValue = $this->_userlevel->lookupCacheOption($curVal);
                    if ($this->_userlevel->ViewValue === null) { // Lookup from database
                        $filterWrk = "`userlevelid`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->_userlevel->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->_userlevel->Lookup->renderViewRow($rswrk[0]);
                            $this->_userlevel->ViewValue = $this->_userlevel->displayValue($arwrk);
                        } else {
                            $this->_userlevel->ViewValue = $this->_userlevel->CurrentValue;
                        }
                    }
                } else {
                    $this->_userlevel->ViewValue = null;
                }
            } else {
                $this->_userlevel->ViewValue = $Language->phrase("PasswordMask");
            }
            $this->_userlevel->ViewCustomAttributes = "";

            // aktif
            if (ConvertToBool($this->aktif->CurrentValue)) {
                $this->aktif->ViewValue = $this->aktif->tagCaption(1) != "" ? $this->aktif->tagCaption(1) : "Y";
            } else {
                $this->aktif->ViewValue = $this->aktif->tagCaption(2) != "" ? $this->aktif->tagCaption(2) : "N";
            }
            $this->aktif->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // user_created_by
            $this->user_created_by->ViewValue = $this->user_created_by->CurrentValue;
            $this->user_created_by->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // user_updated_by
            $this->user_updated_by->ViewValue = $this->user_updated_by->CurrentValue;
            $this->user_updated_by->ViewCustomAttributes = "";

            // nama_peserta
            $this->nama_peserta->ViewValue = $this->nama_peserta->CurrentValue;
            $this->nama_peserta->ViewCustomAttributes = "";

            // perusahaan
            $this->perusahaan->ViewValue = $this->perusahaan->CurrentValue;
            $this->perusahaan->ViewCustomAttributes = "";

            // jabatan
            $this->jabatan->ViewValue = $this->jabatan->CurrentValue;
            $this->jabatan->ViewCustomAttributes = "";

            // provinsi
            $this->provinsi->ViewValue = $this->provinsi->CurrentValue;
            $this->provinsi->ViewValue = FormatNumber($this->provinsi->ViewValue, 0, -2, -2, -2);
            $this->provinsi->ViewCustomAttributes = "";

            // kota
            $this->kota->ViewValue = $this->kota->CurrentValue;
            $this->kota->ViewValue = FormatNumber($this->kota->ViewValue, 0, -2, -2, -2);
            $this->kota->ViewCustomAttributes = "";

            // usaha
            $this->usaha->ViewValue = $this->usaha->CurrentValue;
            $this->usaha->ViewCustomAttributes = "";

            // produk
            $this->produk->ViewValue = $this->produk->CurrentValue;
            $this->produk->ViewCustomAttributes = "";

            // last_login
            $this->last_login->ViewValue = $this->last_login->CurrentValue;
            $this->last_login->ViewValue = FormatDateTime($this->last_login->ViewValue, 0);
            $this->last_login->ViewCustomAttributes = "";

            // user_id
            $this->user_id->LinkCustomAttributes = "";
            $this->user_id->HrefValue = "";
            $this->user_id->TooltipValue = "";

            // user_email
            $this->user_email->LinkCustomAttributes = "";
            $this->user_email->HrefValue = "";
            $this->user_email->TooltipValue = "";

            // no_hp
            $this->no_hp->LinkCustomAttributes = "";
            $this->no_hp->HrefValue = "";
            $this->no_hp->TooltipValue = "";

            // pass
            $this->pass->LinkCustomAttributes = "";
            $this->pass->HrefValue = "";
            $this->pass->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // user_id

            // user_email
            $this->user_email->EditAttrs["class"] = "form-control";
            $this->user_email->EditCustomAttributes = "";
            if (!$this->user_email->Raw) {
                $this->user_email->CurrentValue = HtmlDecode($this->user_email->CurrentValue);
            }
            $this->user_email->EditValue = HtmlEncode($this->user_email->CurrentValue);
            $this->user_email->PlaceHolder = RemoveHtml($this->user_email->caption());

            // no_hp
            $this->no_hp->EditAttrs["class"] = "form-control";
            $this->no_hp->EditCustomAttributes = "";
            if (!$this->no_hp->Raw) {
                $this->no_hp->CurrentValue = HtmlDecode($this->no_hp->CurrentValue);
            }
            $this->no_hp->EditValue = HtmlEncode($this->no_hp->CurrentValue);
            $this->no_hp->PlaceHolder = RemoveHtml($this->no_hp->caption());

            // pass
            $this->pass->EditAttrs["class"] = "form-control";
            $this->pass->EditCustomAttributes = "";
            $curVal = trim(strval($this->pass->CurrentValue));
            if ($curVal != "") {
                $this->pass->ViewValue = $this->pass->lookupCacheOption($curVal);
            } else {
                $this->pass->ViewValue = $this->pass->Lookup !== null && is_array($this->pass->Lookup->Options) ? $curVal : null;
            }
            if ($this->pass->ViewValue !== null) { // Load from cache
                $this->pass->EditValue = array_values($this->pass->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`userlevelid`" . SearchString("=", $this->pass->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->pass->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->pass->EditValue = $arwrk;
            }
            $this->pass->PlaceHolder = RemoveHtml($this->pass->caption());

            // Add refer script

            // user_id
            $this->user_id->LinkCustomAttributes = "";
            $this->user_id->HrefValue = "";

            // user_email
            $this->user_email->LinkCustomAttributes = "";
            $this->user_email->HrefValue = "";

            // no_hp
            $this->no_hp->LinkCustomAttributes = "";
            $this->no_hp->HrefValue = "";

            // pass
            $this->pass->LinkCustomAttributes = "";
            $this->pass->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if ($this->user_id->Required) {
            if (!$this->user_id->IsDetailKey && EmptyValue($this->user_id->FormValue)) {
                $this->user_id->addErrorMessage(str_replace("%s", $this->user_id->caption(), $this->user_id->RequiredErrorMessage));
            }
        }
        if ($this->user_email->Required) {
            if (!$this->user_email->IsDetailKey && EmptyValue($this->user_email->FormValue)) {
                $this->user_email->addErrorMessage($Language->phrase("EnterUserName"));
            }
        }
        if (!CheckEmail($this->user_email->FormValue)) {
            $this->user_email->addErrorMessage($this->user_email->getErrorMessage(false));
        }
        if (!$this->user_email->Raw && Config("REMOVE_XSS") && CheckUsername($this->user_email->FormValue)) {
            $this->user_email->addErrorMessage($Language->phrase("InvalidUsernameChars"));
        }
        if ($this->no_hp->Required) {
            if (!$this->no_hp->IsDetailKey && EmptyValue($this->no_hp->FormValue)) {
                $this->no_hp->addErrorMessage(str_replace("%s", $this->no_hp->caption(), $this->no_hp->RequiredErrorMessage));
            }
        }
        if ($this->pass->Required) {
            if (!$this->pass->IsDetailKey && EmptyValue($this->pass->FormValue)) {
                $this->pass->addErrorMessage($Language->phrase("EnterPassword"));
            }
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;
        if ($this->user_email->CurrentValue != "") { // Check field with unique index
            $filter = "(`user_email` = '" . AdjustSql($this->user_email->CurrentValue, $this->Dbid) . "')";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->user_email->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->user_email->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // user_email
        $this->user_email->setDbValueDef($rsnew, $this->user_email->CurrentValue, "", false);

        // no_hp
        $this->no_hp->setDbValueDef($rsnew, $this->no_hp->CurrentValue, "", false);

        // pass
        $this->pass->setDbValueDef($rsnew, $this->pass->CurrentValue, null, false);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        $addRow = false;
        if ($insertRow) {
            try {
                $addRow = $this->insert($rsnew);
            } catch (\Exception $e) {
                $this->setFailureMessage($e->getMessage());
            }
            if ($addRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);

            // Call User Registered event
            $this->userRegistered($rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_pass":
                    break;
                case "x__userlevel":
                    break;
                case "x_aktif":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll(\PDO::FETCH_BOTH);
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row);
                    $ar[strval($row[0])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'
    public function messageShowing(&$msg, $type)
    {
        // Example:
        //if ($type == 'success') $msg = "your success message";
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email); var_dump($args); exit();
        return true;
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }

    // User Registered event
    public function userRegistered(&$rs)
    {
        //Log("User_Registered");
    }

    // User Activated event
    public function userActivated(&$rs)
    {
        //Log("User_Activated");
    }
}
