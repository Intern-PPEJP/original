<?php

namespace PHPMaker2021\ppejp_web;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class AkunkuEdit extends Akunku
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'akunku';

    // Page object name
    public $PageObjName = "AkunkuEdit";

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
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
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
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
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
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return ($this->TableVar == $CurrentForm->getValue("t"));
            }
            if (Get("t") !== null) {
                return ($this->TableVar == Get("t"));
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (akunku)
        if (!isset($GLOBALS["akunku"]) || get_class($GLOBALS["akunku"]) == PROJECT_NAMESPACE . "akunku") {
            $GLOBALS["akunku"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'akunku');
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

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("akunku"));
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
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
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "akunkuview") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
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
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->user_id->Visible = false;
        }
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
    public $FormClassName = "ew-horizontal ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->user_id->setVisibility();
        $this->user_email->setVisibility();
        $this->no_hp->setVisibility();
        $this->updated_at->setVisibility();
        $this->user_updated_by->setVisibility();
        $this->nama_peserta->setVisibility();
        $this->perusahaan->setVisibility();
        $this->jabatan->setVisibility();
        $this->provinsi->setVisibility();
        $this->kota->setVisibility();
        $this->usaha->setVisibility();
        $this->produk->setVisibility();
        $this->last_login->Visible = false;
        $this->hideFieldsForAddEdit();
        $this->user_email->Required = false;

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->provinsi);
        $this->setupLookupOptions($this->kota);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("user_id") ?? Key(0) ?? Route(2)) !== null) {
                $this->user_id->setQueryStringValue($keyValue);
                $this->user_id->setOldValue($this->user_id->QueryStringValue);
            } elseif (Post("user_id") !== null) {
                $this->user_id->setFormValue(Post("user_id"));
                $this->user_id->setOldValue($this->user_id->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("user_id") ?? Route("user_id")) !== null) {
                    $this->user_id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->user_id->CurrentValue = null;
                }
            }

            // Load recordset
            if ($this->isShow()) {
                // Load current record
                $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$loaded) { // Load record based on key
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("akunkulist"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "akunkulist") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
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

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'user_id' first before field var 'x_user_id'
        $val = $CurrentForm->hasValue("user_id") ? $CurrentForm->getValue("user_id") : $CurrentForm->getValue("x_user_id");
        if (!$this->user_id->IsDetailKey) {
            $this->user_id->setFormValue($val);
        }

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

        // Check field name 'updated_at' first before field var 'x_updated_at'
        $val = $CurrentForm->hasValue("updated_at") ? $CurrentForm->getValue("updated_at") : $CurrentForm->getValue("x_updated_at");
        if (!$this->updated_at->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->updated_at->Visible = false; // Disable update for API request
            } else {
                $this->updated_at->setFormValue($val);
            }
            $this->updated_at->CurrentValue = UnFormatDateTime($this->updated_at->CurrentValue, 0);
        }

        // Check field name 'user_updated_by' first before field var 'x_user_updated_by'
        $val = $CurrentForm->hasValue("user_updated_by") ? $CurrentForm->getValue("user_updated_by") : $CurrentForm->getValue("x_user_updated_by");
        if (!$this->user_updated_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->user_updated_by->Visible = false; // Disable update for API request
            } else {
                $this->user_updated_by->setFormValue($val);
            }
        }

        // Check field name 'nama_peserta' first before field var 'x_nama_peserta'
        $val = $CurrentForm->hasValue("nama_peserta") ? $CurrentForm->getValue("nama_peserta") : $CurrentForm->getValue("x_nama_peserta");
        if (!$this->nama_peserta->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nama_peserta->Visible = false; // Disable update for API request
            } else {
                $this->nama_peserta->setFormValue($val);
            }
        }

        // Check field name 'perusahaan' first before field var 'x_perusahaan'
        $val = $CurrentForm->hasValue("perusahaan") ? $CurrentForm->getValue("perusahaan") : $CurrentForm->getValue("x_perusahaan");
        if (!$this->perusahaan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->perusahaan->Visible = false; // Disable update for API request
            } else {
                $this->perusahaan->setFormValue($val);
            }
        }

        // Check field name 'jabatan' first before field var 'x_jabatan'
        $val = $CurrentForm->hasValue("jabatan") ? $CurrentForm->getValue("jabatan") : $CurrentForm->getValue("x_jabatan");
        if (!$this->jabatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jabatan->Visible = false; // Disable update for API request
            } else {
                $this->jabatan->setFormValue($val);
            }
        }

        // Check field name 'provinsi' first before field var 'x_provinsi'
        $val = $CurrentForm->hasValue("provinsi") ? $CurrentForm->getValue("provinsi") : $CurrentForm->getValue("x_provinsi");
        if (!$this->provinsi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->provinsi->Visible = false; // Disable update for API request
            } else {
                $this->provinsi->setFormValue($val);
            }
        }

        // Check field name 'kota' first before field var 'x_kota'
        $val = $CurrentForm->hasValue("kota") ? $CurrentForm->getValue("kota") : $CurrentForm->getValue("x_kota");
        if (!$this->kota->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kota->Visible = false; // Disable update for API request
            } else {
                $this->kota->setFormValue($val);
            }
        }

        // Check field name 'usaha' first before field var 'x_usaha'
        $val = $CurrentForm->hasValue("usaha") ? $CurrentForm->getValue("usaha") : $CurrentForm->getValue("x_usaha");
        if (!$this->usaha->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->usaha->Visible = false; // Disable update for API request
            } else {
                $this->usaha->setFormValue($val);
            }
        }

        // Check field name 'produk' first before field var 'x_produk'
        $val = $CurrentForm->hasValue("produk") ? $CurrentForm->getValue("produk") : $CurrentForm->getValue("x_produk");
        if (!$this->produk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->produk->Visible = false; // Disable update for API request
            } else {
                $this->produk->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->user_id->CurrentValue = $this->user_id->FormValue;
        $this->user_email->CurrentValue = $this->user_email->FormValue;
        $this->no_hp->CurrentValue = $this->no_hp->FormValue;
        $this->updated_at->CurrentValue = $this->updated_at->FormValue;
        $this->updated_at->CurrentValue = UnFormatDateTime($this->updated_at->CurrentValue, 0);
        $this->user_updated_by->CurrentValue = $this->user_updated_by->FormValue;
        $this->nama_peserta->CurrentValue = $this->nama_peserta->FormValue;
        $this->perusahaan->CurrentValue = $this->perusahaan->FormValue;
        $this->jabatan->CurrentValue = $this->jabatan->FormValue;
        $this->provinsi->CurrentValue = $this->provinsi->FormValue;
        $this->kota->CurrentValue = $this->kota->FormValue;
        $this->usaha->CurrentValue = $this->usaha->FormValue;
        $this->produk->CurrentValue = $this->produk->FormValue;
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

        // Check if valid User ID
        if ($res) {
            $res = $this->showOptionLink("edit");
            if (!$res) {
                $userIdMsg = DeniedMessage();
                $this->setFailureMessage($userIdMsg);
            }
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
        $row = [];
        $row['user_id'] = null;
        $row['user_email'] = null;
        $row['no_hp'] = null;
        $row['updated_at'] = null;
        $row['user_updated_by'] = null;
        $row['nama_peserta'] = null;
        $row['perusahaan'] = null;
        $row['jabatan'] = null;
        $row['provinsi'] = null;
        $row['kota'] = null;
        $row['usaha'] = null;
        $row['produk'] = null;
        $row['last_login'] = null;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
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
            $curVal = trim(strval($this->provinsi->CurrentValue));
            if ($curVal != "") {
                $this->provinsi->ViewValue = $this->provinsi->lookupCacheOption($curVal);
                if ($this->provinsi->ViewValue === null) { // Lookup from database
                    $filterWrk = "`kdprop`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->provinsi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->provinsi->Lookup->renderViewRow($rswrk[0]);
                        $this->provinsi->ViewValue = $this->provinsi->displayValue($arwrk);
                    } else {
                        $this->provinsi->ViewValue = $this->provinsi->CurrentValue;
                    }
                }
            } else {
                $this->provinsi->ViewValue = null;
            }
            $this->provinsi->ViewCustomAttributes = "";

            // kota
            $curVal = trim(strval($this->kota->CurrentValue));
            if ($curVal != "") {
                $this->kota->ViewValue = $this->kota->lookupCacheOption($curVal);
                if ($this->kota->ViewValue === null) { // Lookup from database
                    $filterWrk = "`kdkota`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->kota->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kota->Lookup->renderViewRow($rswrk[0]);
                        $this->kota->ViewValue = $this->kota->displayValue($arwrk);
                    } else {
                        $this->kota->ViewValue = $this->kota->CurrentValue;
                    }
                }
            } else {
                $this->kota->ViewValue = null;
            }
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

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";
            $this->updated_at->TooltipValue = "";

            // user_updated_by
            $this->user_updated_by->LinkCustomAttributes = "";
            $this->user_updated_by->HrefValue = "";
            $this->user_updated_by->TooltipValue = "";

            // nama_peserta
            $this->nama_peserta->LinkCustomAttributes = "";
            $this->nama_peserta->HrefValue = "";
            $this->nama_peserta->TooltipValue = "";

            // perusahaan
            $this->perusahaan->LinkCustomAttributes = "";
            $this->perusahaan->HrefValue = "";
            $this->perusahaan->TooltipValue = "";

            // jabatan
            $this->jabatan->LinkCustomAttributes = "";
            $this->jabatan->HrefValue = "";
            $this->jabatan->TooltipValue = "";

            // provinsi
            $this->provinsi->LinkCustomAttributes = "";
            $this->provinsi->HrefValue = "";
            $this->provinsi->TooltipValue = "";

            // kota
            $this->kota->LinkCustomAttributes = "";
            $this->kota->HrefValue = "";
            $this->kota->TooltipValue = "";

            // usaha
            $this->usaha->LinkCustomAttributes = "";
            $this->usaha->HrefValue = "";
            $this->usaha->TooltipValue = "";

            // produk
            $this->produk->LinkCustomAttributes = "";
            $this->produk->HrefValue = "";
            $this->produk->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // user_id
            $this->user_id->EditAttrs["class"] = "form-control";
            $this->user_id->EditCustomAttributes = "";
            $this->user_id->EditValue = $this->user_id->CurrentValue;
            $this->user_id->ViewCustomAttributes = "";

            // user_email
            $this->user_email->EditAttrs["class"] = "form-control";
            $this->user_email->EditCustomAttributes = "";
            $this->user_email->EditValue = $this->user_email->CurrentValue;
            $this->user_email->ViewCustomAttributes = "";

            // no_hp
            $this->no_hp->EditAttrs["class"] = "form-control";
            $this->no_hp->EditCustomAttributes = "";
            if (!$this->no_hp->Raw) {
                $this->no_hp->CurrentValue = HtmlDecode($this->no_hp->CurrentValue);
            }
            $this->no_hp->EditValue = HtmlEncode($this->no_hp->CurrentValue);
            $this->no_hp->PlaceHolder = RemoveHtml($this->no_hp->caption());

            // updated_at

            // user_updated_by

            // nama_peserta
            $this->nama_peserta->EditAttrs["class"] = "form-control";
            $this->nama_peserta->EditCustomAttributes = "";
            if (!$this->nama_peserta->Raw) {
                $this->nama_peserta->CurrentValue = HtmlDecode($this->nama_peserta->CurrentValue);
            }
            $this->nama_peserta->EditValue = HtmlEncode($this->nama_peserta->CurrentValue);
            $this->nama_peserta->PlaceHolder = RemoveHtml($this->nama_peserta->caption());

            // perusahaan
            $this->perusahaan->EditAttrs["class"] = "form-control";
            $this->perusahaan->EditCustomAttributes = "";
            if (!$this->perusahaan->Raw) {
                $this->perusahaan->CurrentValue = HtmlDecode($this->perusahaan->CurrentValue);
            }
            $this->perusahaan->EditValue = HtmlEncode($this->perusahaan->CurrentValue);
            $this->perusahaan->PlaceHolder = RemoveHtml($this->perusahaan->caption());

            // jabatan
            $this->jabatan->EditAttrs["class"] = "form-control";
            $this->jabatan->EditCustomAttributes = "";
            if (!$this->jabatan->Raw) {
                $this->jabatan->CurrentValue = HtmlDecode($this->jabatan->CurrentValue);
            }
            $this->jabatan->EditValue = HtmlEncode($this->jabatan->CurrentValue);
            $this->jabatan->PlaceHolder = RemoveHtml($this->jabatan->caption());

            // provinsi
            $this->provinsi->EditAttrs["class"] = "form-control";
            $this->provinsi->EditCustomAttributes = "";
            $curVal = trim(strval($this->provinsi->CurrentValue));
            if ($curVal != "") {
                $this->provinsi->ViewValue = $this->provinsi->lookupCacheOption($curVal);
            } else {
                $this->provinsi->ViewValue = $this->provinsi->Lookup !== null && is_array($this->provinsi->Lookup->Options) ? $curVal : null;
            }
            if ($this->provinsi->ViewValue !== null) { // Load from cache
                $this->provinsi->EditValue = array_values($this->provinsi->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`kdprop`" . SearchString("=", $this->provinsi->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->provinsi->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->provinsi->EditValue = $arwrk;
            }
            $this->provinsi->PlaceHolder = RemoveHtml($this->provinsi->caption());

            // kota
            $this->kota->EditAttrs["class"] = "form-control";
            $this->kota->EditCustomAttributes = "";
            $curVal = trim(strval($this->kota->CurrentValue));
            if ($curVal != "") {
                $this->kota->ViewValue = $this->kota->lookupCacheOption($curVal);
            } else {
                $this->kota->ViewValue = $this->kota->Lookup !== null && is_array($this->kota->Lookup->Options) ? $curVal : null;
            }
            if ($this->kota->ViewValue !== null) { // Load from cache
                $this->kota->EditValue = array_values($this->kota->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`kdkota`" . SearchString("=", $this->kota->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->kota->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->kota->EditValue = $arwrk;
            }
            $this->kota->PlaceHolder = RemoveHtml($this->kota->caption());

            // usaha
            $this->usaha->EditAttrs["class"] = "form-control";
            $this->usaha->EditCustomAttributes = "";
            if (!$this->usaha->Raw) {
                $this->usaha->CurrentValue = HtmlDecode($this->usaha->CurrentValue);
            }
            $this->usaha->EditValue = HtmlEncode($this->usaha->CurrentValue);
            $this->usaha->PlaceHolder = RemoveHtml($this->usaha->caption());

            // produk
            $this->produk->EditAttrs["class"] = "form-control";
            $this->produk->EditCustomAttributes = "";
            if (!$this->produk->Raw) {
                $this->produk->CurrentValue = HtmlDecode($this->produk->CurrentValue);
            }
            $this->produk->EditValue = HtmlEncode($this->produk->CurrentValue);
            $this->produk->PlaceHolder = RemoveHtml($this->produk->caption());

            // Edit refer script

            // user_id
            $this->user_id->LinkCustomAttributes = "";
            $this->user_id->HrefValue = "";

            // user_email
            $this->user_email->LinkCustomAttributes = "";
            $this->user_email->HrefValue = "";
            $this->user_email->TooltipValue = "";

            // no_hp
            $this->no_hp->LinkCustomAttributes = "";
            $this->no_hp->HrefValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";

            // user_updated_by
            $this->user_updated_by->LinkCustomAttributes = "";
            $this->user_updated_by->HrefValue = "";

            // nama_peserta
            $this->nama_peserta->LinkCustomAttributes = "";
            $this->nama_peserta->HrefValue = "";

            // perusahaan
            $this->perusahaan->LinkCustomAttributes = "";
            $this->perusahaan->HrefValue = "";

            // jabatan
            $this->jabatan->LinkCustomAttributes = "";
            $this->jabatan->HrefValue = "";

            // provinsi
            $this->provinsi->LinkCustomAttributes = "";
            $this->provinsi->HrefValue = "";

            // kota
            $this->kota->LinkCustomAttributes = "";
            $this->kota->HrefValue = "";

            // usaha
            $this->usaha->LinkCustomAttributes = "";
            $this->usaha->HrefValue = "";

            // produk
            $this->produk->LinkCustomAttributes = "";
            $this->produk->HrefValue = "";
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
                $this->user_email->addErrorMessage(str_replace("%s", $this->user_email->caption(), $this->user_email->RequiredErrorMessage));
            }
        }
        if ($this->no_hp->Required) {
            if (!$this->no_hp->IsDetailKey && EmptyValue($this->no_hp->FormValue)) {
                $this->no_hp->addErrorMessage(str_replace("%s", $this->no_hp->caption(), $this->no_hp->RequiredErrorMessage));
            }
        }
        if ($this->updated_at->Required) {
            if (!$this->updated_at->IsDetailKey && EmptyValue($this->updated_at->FormValue)) {
                $this->updated_at->addErrorMessage(str_replace("%s", $this->updated_at->caption(), $this->updated_at->RequiredErrorMessage));
            }
        }
        if ($this->user_updated_by->Required) {
            if (!$this->user_updated_by->IsDetailKey && EmptyValue($this->user_updated_by->FormValue)) {
                $this->user_updated_by->addErrorMessage(str_replace("%s", $this->user_updated_by->caption(), $this->user_updated_by->RequiredErrorMessage));
            }
        }
        if ($this->nama_peserta->Required) {
            if (!$this->nama_peserta->IsDetailKey && EmptyValue($this->nama_peserta->FormValue)) {
                $this->nama_peserta->addErrorMessage(str_replace("%s", $this->nama_peserta->caption(), $this->nama_peserta->RequiredErrorMessage));
            }
        }
        if ($this->perusahaan->Required) {
            if (!$this->perusahaan->IsDetailKey && EmptyValue($this->perusahaan->FormValue)) {
                $this->perusahaan->addErrorMessage(str_replace("%s", $this->perusahaan->caption(), $this->perusahaan->RequiredErrorMessage));
            }
        }
        if ($this->jabatan->Required) {
            if (!$this->jabatan->IsDetailKey && EmptyValue($this->jabatan->FormValue)) {
                $this->jabatan->addErrorMessage(str_replace("%s", $this->jabatan->caption(), $this->jabatan->RequiredErrorMessage));
            }
        }
        if ($this->provinsi->Required) {
            if (!$this->provinsi->IsDetailKey && EmptyValue($this->provinsi->FormValue)) {
                $this->provinsi->addErrorMessage(str_replace("%s", $this->provinsi->caption(), $this->provinsi->RequiredErrorMessage));
            }
        }
        if ($this->kota->Required) {
            if (!$this->kota->IsDetailKey && EmptyValue($this->kota->FormValue)) {
                $this->kota->addErrorMessage(str_replace("%s", $this->kota->caption(), $this->kota->RequiredErrorMessage));
            }
        }
        if ($this->usaha->Required) {
            if (!$this->usaha->IsDetailKey && EmptyValue($this->usaha->FormValue)) {
                $this->usaha->addErrorMessage(str_replace("%s", $this->usaha->caption(), $this->usaha->RequiredErrorMessage));
            }
        }
        if ($this->produk->Required) {
            if (!$this->produk->IsDetailKey && EmptyValue($this->produk->FormValue)) {
                $this->produk->addErrorMessage(str_replace("%s", $this->produk->caption(), $this->produk->RequiredErrorMessage));
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

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        if ($this->user_email->CurrentValue != "") { // Check field with unique index
            $filterChk = "(w_users.user_email = '" . AdjustSql($this->user_email->CurrentValue, $this->Dbid) . "')";
            $filterChk .= " AND NOT (" . $filter . ")";
            $this->CurrentFilter = $filterChk;
            $sqlChk = $this->getCurrentSql();
            $rsChk = $conn->executeQuery($sqlChk);
            if (!$rsChk) {
                return false;
            }
            if ($rsChk->fetch()) {
                $idxErrMsg = str_replace("%f", $this->user_email->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->user_email->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                $rsChk->closeCursor();
                return false;
            }
        }
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssoc($sql);
        $editRow = false;
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // no_hp
            $this->no_hp->setDbValueDef($rsnew, $this->no_hp->CurrentValue, "", $this->no_hp->ReadOnly);

            // updated_at
            $this->updated_at->CurrentValue = CurrentDateTime();
            $this->updated_at->setDbValueDef($rsnew, $this->updated_at->CurrentValue, null);

            // user_updated_by
            $this->user_updated_by->CurrentValue = CurrentUserName();
            $this->user_updated_by->setDbValueDef($rsnew, $this->user_updated_by->CurrentValue, null);

            // nama_peserta
            $this->nama_peserta->setDbValueDef($rsnew, $this->nama_peserta->CurrentValue, "", $this->nama_peserta->ReadOnly);

            // perusahaan
            $this->perusahaan->setDbValueDef($rsnew, $this->perusahaan->CurrentValue, "", $this->perusahaan->ReadOnly);

            // jabatan
            $this->jabatan->setDbValueDef($rsnew, $this->jabatan->CurrentValue, "", $this->jabatan->ReadOnly);

            // provinsi
            $this->provinsi->setDbValueDef($rsnew, $this->provinsi->CurrentValue, 0, $this->provinsi->ReadOnly);

            // kota
            $this->kota->setDbValueDef($rsnew, $this->kota->CurrentValue, 0, $this->kota->ReadOnly);

            // usaha
            $this->usaha->setDbValueDef($rsnew, $this->usaha->CurrentValue, null, $this->usaha->ReadOnly);

            // produk
            $this->produk->setDbValueDef($rsnew, $this->produk->CurrentValue, null, $this->produk->ReadOnly);

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    try {
                        $editRow = $this->update($rsnew, "", $rsold);
                    } catch (\Exception $e) {
                        $this->setFailureMessage($e->getMessage());
                    }
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                }
            } else {
                if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                    // Use the message, do nothing
                } elseif ($this->CancelMessage != "") {
                    $this->setFailureMessage($this->CancelMessage);
                    $this->CancelMessage = "";
                } else {
                    $this->setFailureMessage($Language->phrase("UpdateCancelled"));
                }
                $editRow = false;
            }
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Show link optionally based on User ID
    protected function showOptionLink($id = "")
    {
        global $Security;
        if ($Security->isLoggedIn() && !$Security->isAdmin() && !$this->userIDAllow($id)) {
            return $Security->isValidUserID($this->user_id->CurrentValue);
        }
        return true;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("akunkulist"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
                case "x_provinsi":
                    break;
                case "x_kota":
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            $pageNo = Get(Config("TABLE_PAGE_NO"));
            if ($pageNo !== null) { // Check for "pageno" parameter first
                if (is_numeric($pageNo)) {
                    $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                    if ($this->StartRecord <= 0) {
                        $this->StartRecord = 1;
                    } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                        $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                    }
                    $this->setStartRecordNumber($this->StartRecord);
                }
            } elseif ($startRec !== null) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
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
		if(CurrentUserInfo("user_id") != $this->user_id->CurrentValue){
			$url = "akun";
		}
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
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
        $this->user_id->Visible = FALSE;
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }
}
