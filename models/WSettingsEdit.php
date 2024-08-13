<?php

namespace PHPMaker2021\ppejp_web;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class WSettingsEdit extends WSettings
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'w_settings';

    // Page object name
    public $PageObjName = "WSettingsEdit";

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

        // Table object (w_settings)
        if (!isset($GLOBALS["w_settings"]) || get_class($GLOBALS["w_settings"]) == PROJECT_NAMESPACE . "w_settings") {
            $GLOBALS["w_settings"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'w_settings');
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
                $doc = new $class(Container("w_settings"));
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
                    if ($pageName == "wsettingsview") {
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
		        $this->Logo->OldUploadPath = "images/";
		        $this->Logo->UploadPath = $this->Logo->OldUploadPath;
		        $this->Login_Picture->OldUploadPath = "images/";
		        $this->Login_Picture->UploadPath = $this->Login_Picture->OldUploadPath;
		        $this->Register_Picture->OldUploadPath = "images/";
		        $this->Register_Picture->UploadPath = $this->Register_Picture->OldUploadPath;
		        $this->Popup_Picture->OldUploadPath = "images/popup";
		        $this->Popup_Picture->UploadPath = $this->Popup_Picture->OldUploadPath;
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
            $key .= @$ar['ID'];
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
    public $MultiPages; // Multi pages object

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
        $this->ID->setVisibility();
        $this->Logo->setVisibility();
        $this->Login_Picture->setVisibility();
        $this->Register_Picture->setVisibility();
        $this->Popup_Show->setVisibility();
        $this->Popup_Picture->setVisibility();
        $this->Popup_Link->setVisibility();
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Set up multi page object
        $this->setupMultiPages();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache

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
            if (($keyValue = Get("ID") ?? Key(0) ?? Route(2)) !== null) {
                $this->ID->setQueryStringValue($keyValue);
                $this->ID->setOldValue($this->ID->QueryStringValue);
            } elseif (Post("ID") !== null) {
                $this->ID->setFormValue(Post("ID"));
                $this->ID->setOldValue($this->ID->FormValue);
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
                if (($keyValue = Get("ID") ?? Route("ID")) !== null) {
                    $this->ID->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->ID->CurrentValue = null;
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
                    $this->terminate("wsettingslist"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->GetEditUrl();
                if (GetPageName($returnUrl) == "wsettingslist") {
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
        $this->Logo->Upload->Index = $CurrentForm->Index;
        $this->Logo->Upload->uploadFile();
        $this->Logo->CurrentValue = $this->Logo->Upload->FileName;
        $this->Login_Picture->Upload->Index = $CurrentForm->Index;
        $this->Login_Picture->Upload->uploadFile();
        $this->Login_Picture->CurrentValue = $this->Login_Picture->Upload->FileName;
        $this->Register_Picture->Upload->Index = $CurrentForm->Index;
        $this->Register_Picture->Upload->uploadFile();
        $this->Register_Picture->CurrentValue = $this->Register_Picture->Upload->FileName;
        $this->Popup_Picture->Upload->Index = $CurrentForm->Index;
        $this->Popup_Picture->Upload->uploadFile();
        $this->Popup_Picture->CurrentValue = $this->Popup_Picture->Upload->FileName;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'ID' first before field var 'x_ID'
        $val = $CurrentForm->hasValue("ID") ? $CurrentForm->getValue("ID") : $CurrentForm->getValue("x_ID");
        if (!$this->ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ID->Visible = false; // Disable update for API request
            } else {
                $this->ID->setFormValue($val);
            }
        }

        // Check field name 'Popup_Show' first before field var 'x_Popup_Show'
        $val = $CurrentForm->hasValue("Popup_Show") ? $CurrentForm->getValue("Popup_Show") : $CurrentForm->getValue("x_Popup_Show");
        if (!$this->Popup_Show->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Popup_Show->Visible = false; // Disable update for API request
            } else {
                $this->Popup_Show->setFormValue($val);
            }
        }

        // Check field name 'Popup_Link' first before field var 'x_Popup_Link'
        $val = $CurrentForm->hasValue("Popup_Link") ? $CurrentForm->getValue("Popup_Link") : $CurrentForm->getValue("x_Popup_Link");
        if (!$this->Popup_Link->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Popup_Link->Visible = false; // Disable update for API request
            } else {
                $this->Popup_Link->setFormValue($val);
            }
        }
		$this->Logo->OldUploadPath = "images/";
		$this->Logo->UploadPath = $this->Logo->OldUploadPath;
		$this->Login_Picture->OldUploadPath = "images/";
		$this->Login_Picture->UploadPath = $this->Login_Picture->OldUploadPath;
		$this->Register_Picture->OldUploadPath = "images/";
		$this->Register_Picture->UploadPath = $this->Register_Picture->OldUploadPath;
		$this->Popup_Picture->OldUploadPath = "images/popup";
		$this->Popup_Picture->UploadPath = $this->Popup_Picture->OldUploadPath;
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->ID->CurrentValue = $this->ID->FormValue;
        $this->Popup_Show->CurrentValue = $this->Popup_Show->FormValue;
        $this->Popup_Link->CurrentValue = $this->Popup_Link->FormValue;
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
        $this->ID->setDbValue($row['ID']);
        $this->Logo->Upload->DbValue = $row['Logo'];
        $this->Logo->setDbValue($this->Logo->Upload->DbValue);
        $this->Login_Picture->Upload->DbValue = $row['Login_Picture'];
        $this->Login_Picture->setDbValue($this->Login_Picture->Upload->DbValue);
        $this->Register_Picture->Upload->DbValue = $row['Register_Picture'];
        $this->Register_Picture->setDbValue($this->Register_Picture->Upload->DbValue);
        $this->Popup_Show->setDbValue($row['Popup_Show']);
        $this->Popup_Picture->Upload->DbValue = $row['Popup_Picture'];
        $this->Popup_Picture->setDbValue($this->Popup_Picture->Upload->DbValue);
        $this->Popup_Link->setDbValue($row['Popup_Link']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['ID'] = null;
        $row['Logo'] = null;
        $row['Login_Picture'] = null;
        $row['Register_Picture'] = null;
        $row['Popup_Show'] = null;
        $row['Popup_Picture'] = null;
        $row['Popup_Link'] = null;
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

        // ID

        // Logo

        // Login_Picture

        // Register_Picture

        // Popup_Show

        // Popup_Picture

        // Popup_Link
        if ($this->RowType == ROWTYPE_VIEW) {
            // ID
            $this->ID->ViewValue = $this->ID->CurrentValue;
            $this->ID->ViewCustomAttributes = "";

            // Logo
            $this->Logo->UploadPath = "images/";
            if (!EmptyValue($this->Logo->Upload->DbValue)) {
                $this->Logo->ViewValue = $this->Logo->Upload->DbValue;
            } else {
                $this->Logo->ViewValue = "";
            }
            $this->Logo->ViewCustomAttributes = "";

            // Login_Picture
            $this->Login_Picture->UploadPath = "images/";
            if (!EmptyValue($this->Login_Picture->Upload->DbValue)) {
                $this->Login_Picture->ViewValue = $this->Login_Picture->Upload->DbValue;
            } else {
                $this->Login_Picture->ViewValue = "";
            }
            $this->Login_Picture->ViewCustomAttributes = "";

            // Register_Picture
            $this->Register_Picture->UploadPath = "images/";
            if (!EmptyValue($this->Register_Picture->Upload->DbValue)) {
                $this->Register_Picture->ViewValue = $this->Register_Picture->Upload->DbValue;
            } else {
                $this->Register_Picture->ViewValue = "";
            }
            $this->Register_Picture->ViewCustomAttributes = "";

            // Popup_Show
            if (strval($this->Popup_Show->CurrentValue) != "") {
                $this->Popup_Show->ViewValue = $this->Popup_Show->optionCaption($this->Popup_Show->CurrentValue);
            } else {
                $this->Popup_Show->ViewValue = null;
            }
            $this->Popup_Show->ViewCustomAttributes = "";

            // Popup_Picture
            $this->Popup_Picture->UploadPath = "images/popup";
            if (!EmptyValue($this->Popup_Picture->Upload->DbValue)) {
                $this->Popup_Picture->ViewValue = $this->Popup_Picture->Upload->DbValue;
            } else {
                $this->Popup_Picture->ViewValue = "";
            }
            $this->Popup_Picture->ViewCustomAttributes = "";

            // Popup_Link
            $this->Popup_Link->ViewValue = $this->Popup_Link->CurrentValue;
            $this->Popup_Link->ViewCustomAttributes = "";

            // ID
            $this->ID->LinkCustomAttributes = "";
            $this->ID->HrefValue = "";
            $this->ID->TooltipValue = "";

            // Logo
            $this->Logo->LinkCustomAttributes = "";
            $this->Logo->HrefValue = "";
            $this->Logo->ExportHrefValue = $this->Logo->UploadPath . $this->Logo->Upload->DbValue;
            $this->Logo->TooltipValue = "";

            // Login_Picture
            $this->Login_Picture->LinkCustomAttributes = "";
            $this->Login_Picture->HrefValue = "";
            $this->Login_Picture->ExportHrefValue = $this->Login_Picture->UploadPath . $this->Login_Picture->Upload->DbValue;
            $this->Login_Picture->TooltipValue = "";

            // Register_Picture
            $this->Register_Picture->LinkCustomAttributes = "";
            $this->Register_Picture->HrefValue = "";
            $this->Register_Picture->ExportHrefValue = $this->Register_Picture->UploadPath . $this->Register_Picture->Upload->DbValue;
            $this->Register_Picture->TooltipValue = "";

            // Popup_Show
            $this->Popup_Show->LinkCustomAttributes = "";
            $this->Popup_Show->HrefValue = "";
            $this->Popup_Show->TooltipValue = "";

            // Popup_Picture
            $this->Popup_Picture->LinkCustomAttributes = "";
            $this->Popup_Picture->HrefValue = "";
            $this->Popup_Picture->ExportHrefValue = $this->Popup_Picture->UploadPath . $this->Popup_Picture->Upload->DbValue;
            $this->Popup_Picture->TooltipValue = "";

            // Popup_Link
            $this->Popup_Link->LinkCustomAttributes = "";
            $this->Popup_Link->HrefValue = "";
            $this->Popup_Link->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // ID
            $this->ID->EditAttrs["class"] = "form-control";
            $this->ID->EditCustomAttributes = "";

            // Logo
            $this->Logo->EditAttrs["class"] = "form-control";
            $this->Logo->EditCustomAttributes = "";
            $this->Logo->UploadPath = "images/";
            if (!EmptyValue($this->Logo->Upload->DbValue)) {
                $this->Logo->EditValue = $this->Logo->Upload->DbValue;
            } else {
                $this->Logo->EditValue = "";
            }
            if (!EmptyValue($this->Logo->CurrentValue)) {
                $this->Logo->Upload->FileName = $this->Logo->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->Logo);
            }

            // Login_Picture
            $this->Login_Picture->EditAttrs["class"] = "form-control";
            $this->Login_Picture->EditCustomAttributes = "";
            $this->Login_Picture->UploadPath = "images/";
            if (!EmptyValue($this->Login_Picture->Upload->DbValue)) {
                $this->Login_Picture->EditValue = $this->Login_Picture->Upload->DbValue;
            } else {
                $this->Login_Picture->EditValue = "";
            }
            if (!EmptyValue($this->Login_Picture->CurrentValue)) {
                $this->Login_Picture->Upload->FileName = $this->Login_Picture->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->Login_Picture);
            }

            // Register_Picture
            $this->Register_Picture->EditAttrs["class"] = "form-control";
            $this->Register_Picture->EditCustomAttributes = "";
            $this->Register_Picture->UploadPath = "images/";
            if (!EmptyValue($this->Register_Picture->Upload->DbValue)) {
                $this->Register_Picture->EditValue = $this->Register_Picture->Upload->DbValue;
            } else {
                $this->Register_Picture->EditValue = "";
            }
            if (!EmptyValue($this->Register_Picture->CurrentValue)) {
                $this->Register_Picture->Upload->FileName = $this->Register_Picture->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->Register_Picture);
            }

            // Popup_Show
            $this->Popup_Show->EditCustomAttributes = "";
            $this->Popup_Show->EditValue = $this->Popup_Show->options(false);
            $this->Popup_Show->PlaceHolder = RemoveHtml($this->Popup_Show->caption());

            // Popup_Picture
            $this->Popup_Picture->EditAttrs["class"] = "form-control";
            $this->Popup_Picture->EditCustomAttributes = "";
            $this->Popup_Picture->UploadPath = "images/popup";
            if (!EmptyValue($this->Popup_Picture->Upload->DbValue)) {
                $this->Popup_Picture->EditValue = $this->Popup_Picture->Upload->DbValue;
            } else {
                $this->Popup_Picture->EditValue = "";
            }
            if (!EmptyValue($this->Popup_Picture->CurrentValue)) {
                $this->Popup_Picture->Upload->FileName = $this->Popup_Picture->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->Popup_Picture);
            }

            // Popup_Link
            $this->Popup_Link->EditAttrs["class"] = "form-control";
            $this->Popup_Link->EditCustomAttributes = "";
            $this->Popup_Link->EditValue = HtmlEncode($this->Popup_Link->CurrentValue);
            $this->Popup_Link->PlaceHolder = RemoveHtml($this->Popup_Link->caption());

            // Edit refer script

            // ID
            $this->ID->LinkCustomAttributes = "";
            $this->ID->HrefValue = "";
            $this->ID->TooltipValue = "";

            // Logo
            $this->Logo->LinkCustomAttributes = "";
            $this->Logo->HrefValue = "";
            $this->Logo->ExportHrefValue = $this->Logo->UploadPath . $this->Logo->Upload->DbValue;

            // Login_Picture
            $this->Login_Picture->LinkCustomAttributes = "";
            $this->Login_Picture->HrefValue = "";
            $this->Login_Picture->ExportHrefValue = $this->Login_Picture->UploadPath . $this->Login_Picture->Upload->DbValue;

            // Register_Picture
            $this->Register_Picture->LinkCustomAttributes = "";
            $this->Register_Picture->HrefValue = "";
            $this->Register_Picture->ExportHrefValue = $this->Register_Picture->UploadPath . $this->Register_Picture->Upload->DbValue;

            // Popup_Show
            $this->Popup_Show->LinkCustomAttributes = "";
            $this->Popup_Show->HrefValue = "";

            // Popup_Picture
            $this->Popup_Picture->LinkCustomAttributes = "";
            $this->Popup_Picture->HrefValue = "";
            $this->Popup_Picture->ExportHrefValue = $this->Popup_Picture->UploadPath . $this->Popup_Picture->Upload->DbValue;

            // Popup_Link
            $this->Popup_Link->LinkCustomAttributes = "";
            $this->Popup_Link->HrefValue = "";
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
        if ($this->ID->Required) {
            if (!$this->ID->IsDetailKey && EmptyValue($this->ID->FormValue)) {
                $this->ID->addErrorMessage(str_replace("%s", $this->ID->caption(), $this->ID->RequiredErrorMessage));
            }
        }
        if ($this->Logo->Required) {
            if ($this->Logo->Upload->FileName == "" && !$this->Logo->Upload->KeepFile) {
                $this->Logo->addErrorMessage(str_replace("%s", $this->Logo->caption(), $this->Logo->RequiredErrorMessage));
            }
        }
        if ($this->Login_Picture->Required) {
            if ($this->Login_Picture->Upload->FileName == "" && !$this->Login_Picture->Upload->KeepFile) {
                $this->Login_Picture->addErrorMessage(str_replace("%s", $this->Login_Picture->caption(), $this->Login_Picture->RequiredErrorMessage));
            }
        }
        if ($this->Register_Picture->Required) {
            if ($this->Register_Picture->Upload->FileName == "" && !$this->Register_Picture->Upload->KeepFile) {
                $this->Register_Picture->addErrorMessage(str_replace("%s", $this->Register_Picture->caption(), $this->Register_Picture->RequiredErrorMessage));
            }
        }
        if ($this->Popup_Show->Required) {
            if ($this->Popup_Show->FormValue == "") {
                $this->Popup_Show->addErrorMessage(str_replace("%s", $this->Popup_Show->caption(), $this->Popup_Show->RequiredErrorMessage));
            }
        }
        if ($this->Popup_Picture->Required) {
            if ($this->Popup_Picture->Upload->FileName == "" && !$this->Popup_Picture->Upload->KeepFile) {
                $this->Popup_Picture->addErrorMessage(str_replace("%s", $this->Popup_Picture->caption(), $this->Popup_Picture->RequiredErrorMessage));
            }
        }
        if ($this->Popup_Link->Required) {
            if (!$this->Popup_Link->IsDetailKey && EmptyValue($this->Popup_Link->FormValue)) {
                $this->Popup_Link->addErrorMessage(str_replace("%s", $this->Popup_Link->caption(), $this->Popup_Link->RequiredErrorMessage));
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
            $this->Logo->OldUploadPath = "images/";
            $this->Logo->UploadPath = $this->Logo->OldUploadPath;
            $this->Login_Picture->OldUploadPath = "images/";
            $this->Login_Picture->UploadPath = $this->Login_Picture->OldUploadPath;
            $this->Register_Picture->OldUploadPath = "images/";
            $this->Register_Picture->UploadPath = $this->Register_Picture->OldUploadPath;
            $this->Popup_Picture->OldUploadPath = "images/popup";
            $this->Popup_Picture->UploadPath = $this->Popup_Picture->OldUploadPath;
            $rsnew = [];

            // Logo
            if ($this->Logo->Visible && !$this->Logo->ReadOnly && !$this->Logo->Upload->KeepFile) {
                $this->Logo->Upload->DbValue = $rsold['Logo']; // Get original value
                if ($this->Logo->Upload->FileName == "") {
                    $rsnew['Logo'] = null;
                } else {
                    $rsnew['Logo'] = $this->Logo->Upload->FileName;
                }
            }

            // Login_Picture
            if ($this->Login_Picture->Visible && !$this->Login_Picture->ReadOnly && !$this->Login_Picture->Upload->KeepFile) {
                $this->Login_Picture->Upload->DbValue = $rsold['Login_Picture']; // Get original value
                if ($this->Login_Picture->Upload->FileName == "") {
                    $rsnew['Login_Picture'] = null;
                } else {
                    $rsnew['Login_Picture'] = $this->Login_Picture->Upload->FileName;
                }
            }

            // Register_Picture
            if ($this->Register_Picture->Visible && !$this->Register_Picture->ReadOnly && !$this->Register_Picture->Upload->KeepFile) {
                $this->Register_Picture->Upload->DbValue = $rsold['Register_Picture']; // Get original value
                if ($this->Register_Picture->Upload->FileName == "") {
                    $rsnew['Register_Picture'] = null;
                } else {
                    $rsnew['Register_Picture'] = $this->Register_Picture->Upload->FileName;
                }
            }

            // Popup_Show
            $this->Popup_Show->setDbValueDef($rsnew, $this->Popup_Show->CurrentValue, 0, $this->Popup_Show->ReadOnly);

            // Popup_Picture
            if ($this->Popup_Picture->Visible && !$this->Popup_Picture->ReadOnly && !$this->Popup_Picture->Upload->KeepFile) {
                $this->Popup_Picture->Upload->DbValue = $rsold['Popup_Picture']; // Get original value
                if ($this->Popup_Picture->Upload->FileName == "") {
                    $rsnew['Popup_Picture'] = null;
                } else {
                    $rsnew['Popup_Picture'] = $this->Popup_Picture->Upload->FileName;
                }
                $this->Popup_Picture->ImageWidth = 1080; // Resize width
                $this->Popup_Picture->ImageHeight = 1080; // Resize height
            }

            // Popup_Link
            $this->Popup_Link->setDbValueDef($rsnew, $this->Popup_Link->CurrentValue, null, $this->Popup_Link->ReadOnly);
            if ($this->Logo->Visible && !$this->Logo->Upload->KeepFile) {
                $this->Logo->UploadPath = "images/";
                $oldFiles = EmptyValue($this->Logo->Upload->DbValue) ? [] : [$this->Logo->htmlDecode($this->Logo->Upload->DbValue)];
                if (!EmptyValue($this->Logo->Upload->FileName)) {
                    $newFiles = [$this->Logo->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->Logo, $this->Logo->Upload->Index);
                            if (file_exists($tempPath . $file)) {
                                if (Config("DELETE_UPLOADED_FILES")) {
                                    $oldFileFound = false;
                                    $oldFileCount = count($oldFiles);
                                    for ($j = 0; $j < $oldFileCount; $j++) {
                                        $oldFile = $oldFiles[$j];
                                        if ($oldFile == $file) { // Old file found, no need to delete anymore
                                            array_splice($oldFiles, $j, 1);
                                            $oldFileFound = true;
                                            break;
                                        }
                                    }
                                    if ($oldFileFound) { // No need to check if file exists further
                                        continue;
                                    }
                                }
                                $file1 = UniqueFilename($this->Logo->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->Logo->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->Logo->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->Logo->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->Logo->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->Logo->setDbValueDef($rsnew, $this->Logo->Upload->FileName, null, $this->Logo->ReadOnly);
                }
            }
            if ($this->Login_Picture->Visible && !$this->Login_Picture->Upload->KeepFile) {
                $this->Login_Picture->UploadPath = "images/";
                $oldFiles = EmptyValue($this->Login_Picture->Upload->DbValue) ? [] : [$this->Login_Picture->htmlDecode($this->Login_Picture->Upload->DbValue)];
                if (!EmptyValue($this->Login_Picture->Upload->FileName)) {
                    $newFiles = [$this->Login_Picture->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->Login_Picture, $this->Login_Picture->Upload->Index);
                            if (file_exists($tempPath . $file)) {
                                if (Config("DELETE_UPLOADED_FILES")) {
                                    $oldFileFound = false;
                                    $oldFileCount = count($oldFiles);
                                    for ($j = 0; $j < $oldFileCount; $j++) {
                                        $oldFile = $oldFiles[$j];
                                        if ($oldFile == $file) { // Old file found, no need to delete anymore
                                            array_splice($oldFiles, $j, 1);
                                            $oldFileFound = true;
                                            break;
                                        }
                                    }
                                    if ($oldFileFound) { // No need to check if file exists further
                                        continue;
                                    }
                                }
                                $file1 = UniqueFilename($this->Login_Picture->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->Login_Picture->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->Login_Picture->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->Login_Picture->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->Login_Picture->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->Login_Picture->setDbValueDef($rsnew, $this->Login_Picture->Upload->FileName, null, $this->Login_Picture->ReadOnly);
                }
            }
            if ($this->Register_Picture->Visible && !$this->Register_Picture->Upload->KeepFile) {
                $this->Register_Picture->UploadPath = "images/";
                $oldFiles = EmptyValue($this->Register_Picture->Upload->DbValue) ? [] : [$this->Register_Picture->htmlDecode($this->Register_Picture->Upload->DbValue)];
                if (!EmptyValue($this->Register_Picture->Upload->FileName)) {
                    $newFiles = [$this->Register_Picture->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->Register_Picture, $this->Register_Picture->Upload->Index);
                            if (file_exists($tempPath . $file)) {
                                if (Config("DELETE_UPLOADED_FILES")) {
                                    $oldFileFound = false;
                                    $oldFileCount = count($oldFiles);
                                    for ($j = 0; $j < $oldFileCount; $j++) {
                                        $oldFile = $oldFiles[$j];
                                        if ($oldFile == $file) { // Old file found, no need to delete anymore
                                            array_splice($oldFiles, $j, 1);
                                            $oldFileFound = true;
                                            break;
                                        }
                                    }
                                    if ($oldFileFound) { // No need to check if file exists further
                                        continue;
                                    }
                                }
                                $file1 = UniqueFilename($this->Register_Picture->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->Register_Picture->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->Register_Picture->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->Register_Picture->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->Register_Picture->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->Register_Picture->setDbValueDef($rsnew, $this->Register_Picture->Upload->FileName, null, $this->Register_Picture->ReadOnly);
                }
            }
            if ($this->Popup_Picture->Visible && !$this->Popup_Picture->Upload->KeepFile) {
                $this->Popup_Picture->UploadPath = "images/popup";
                $oldFiles = EmptyValue($this->Popup_Picture->Upload->DbValue) ? [] : explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->Popup_Picture->htmlDecode(strval($this->Popup_Picture->Upload->DbValue)));
                if (!EmptyValue($this->Popup_Picture->Upload->FileName)) {
                    $newFiles = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), strval($this->Popup_Picture->Upload->FileName));
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->Popup_Picture, $this->Popup_Picture->Upload->Index);
                            if (file_exists($tempPath . $file)) {
                                if (Config("DELETE_UPLOADED_FILES")) {
                                    $oldFileFound = false;
                                    $oldFileCount = count($oldFiles);
                                    for ($j = 0; $j < $oldFileCount; $j++) {
                                        $oldFile = $oldFiles[$j];
                                        if ($oldFile == $file) { // Old file found, no need to delete anymore
                                            array_splice($oldFiles, $j, 1);
                                            $oldFileFound = true;
                                            break;
                                        }
                                    }
                                    if ($oldFileFound) { // No need to check if file exists further
                                        continue;
                                    }
                                }
                                $file1 = UniqueFilename($this->Popup_Picture->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->Popup_Picture->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->Popup_Picture->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->Popup_Picture->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->Popup_Picture->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->Popup_Picture->setDbValueDef($rsnew, $this->Popup_Picture->Upload->FileName, null, $this->Popup_Picture->ReadOnly);
                }
            }

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);

            // Check for duplicate key when key changed
            if ($updateRow) {
                $newKeyFilter = $this->getRecordFilter($rsnew);
                if ($newKeyFilter != $oldKeyFilter) {
                    $rsChk = $this->loadRs($newKeyFilter)->fetch();
                    if ($rsChk !== false) {
                        $keyErrMsg = str_replace("%f", $newKeyFilter, $Language->phrase("DupKey"));
                        $this->setFailureMessage($keyErrMsg);
                        $updateRow = false;
                    }
                }
            }
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
                    if ($this->Logo->Visible && !$this->Logo->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->Logo->Upload->DbValue) ? [] : [$this->Logo->htmlDecode($this->Logo->Upload->DbValue)];
                        if (!EmptyValue($this->Logo->Upload->FileName)) {
                            $newFiles = [$this->Logo->Upload->FileName];
                            $newFiles2 = [$this->Logo->htmlDecode($rsnew['Logo'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->Logo, $this->Logo->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->Logo->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                            $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                            return false;
                                        }
                                    }
                                }
                            }
                        } else {
                            $newFiles = [];
                        }
                        if (Config("DELETE_UPLOADED_FILES")) {
                            foreach ($oldFiles as $oldFile) {
                                if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                    @unlink($this->Logo->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
                    if ($this->Login_Picture->Visible && !$this->Login_Picture->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->Login_Picture->Upload->DbValue) ? [] : [$this->Login_Picture->htmlDecode($this->Login_Picture->Upload->DbValue)];
                        if (!EmptyValue($this->Login_Picture->Upload->FileName)) {
                            $newFiles = [$this->Login_Picture->Upload->FileName];
                            $newFiles2 = [$this->Login_Picture->htmlDecode($rsnew['Login_Picture'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->Login_Picture, $this->Login_Picture->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->Login_Picture->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                            $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                            return false;
                                        }
                                    }
                                }
                            }
                        } else {
                            $newFiles = [];
                        }
                        if (Config("DELETE_UPLOADED_FILES")) {
                            foreach ($oldFiles as $oldFile) {
                                if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                    @unlink($this->Login_Picture->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
                    if ($this->Register_Picture->Visible && !$this->Register_Picture->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->Register_Picture->Upload->DbValue) ? [] : [$this->Register_Picture->htmlDecode($this->Register_Picture->Upload->DbValue)];
                        if (!EmptyValue($this->Register_Picture->Upload->FileName)) {
                            $newFiles = [$this->Register_Picture->Upload->FileName];
                            $newFiles2 = [$this->Register_Picture->htmlDecode($rsnew['Register_Picture'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->Register_Picture, $this->Register_Picture->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->Register_Picture->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                            $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                            return false;
                                        }
                                    }
                                }
                            }
                        } else {
                            $newFiles = [];
                        }
                        if (Config("DELETE_UPLOADED_FILES")) {
                            foreach ($oldFiles as $oldFile) {
                                if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                    @unlink($this->Register_Picture->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
                    if ($this->Popup_Picture->Visible && !$this->Popup_Picture->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->Popup_Picture->Upload->DbValue) ? [] : explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->Popup_Picture->htmlDecode(strval($this->Popup_Picture->Upload->DbValue)));
                        if (!EmptyValue($this->Popup_Picture->Upload->FileName)) {
                            $newFiles = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->Popup_Picture->Upload->FileName);
                            $newFiles2 = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->Popup_Picture->htmlDecode($rsnew['Popup_Picture']));
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->Popup_Picture, $this->Popup_Picture->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->Popup_Picture->Upload->ResizeAndSaveToFile($this->Popup_Picture->ImageWidth, $this->Popup_Picture->ImageHeight, 100, $newFiles[$i], true, $i)) {
                                            $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                            return false;
                                        }
                                    }
                                }
                            }
                        } else {
                            $newFiles = [];
                        }
                        if (Config("DELETE_UPLOADED_FILES")) {
                            foreach ($oldFiles as $oldFile) {
                                if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                    @unlink($this->Popup_Picture->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
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
            // Logo
            CleanUploadTempPath($this->Logo, $this->Logo->Upload->Index);

            // Login_Picture
            CleanUploadTempPath($this->Login_Picture, $this->Login_Picture->Upload->Index);

            // Register_Picture
            CleanUploadTempPath($this->Register_Picture, $this->Register_Picture->Upload->Index);

            // Popup_Picture
            CleanUploadTempPath($this->Popup_Picture, $this->Popup_Picture->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("wsettingslist"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
    }

    // Set up multi pages
    protected function setupMultiPages()
    {
        $pages = new SubPages();
        $pages->Style = "tabs";
        $pages->add(0);
        $pages->add(1);
        $pages->add(2);
        $this->MultiPages = $pages;
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
                case "x_Popup_Show":
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
