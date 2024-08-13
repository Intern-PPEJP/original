<?php

namespace PHPMaker2021\ppejp_web;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class WPagesEdit extends WPages
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'w_pages';

    // Page object name
    public $PageObjName = "WPagesEdit";

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

        // Table object (w_pages)
        if (!isset($GLOBALS["w_pages"]) || get_class($GLOBALS["w_pages"]) == PROJECT_NAMESPACE . "w_pages") {
            $GLOBALS["w_pages"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'w_pages');
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
                $doc = new $class(Container("w_pages"));
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
                    if ($pageName == "wpagesview") {
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
            $key .= @$ar['custom_url'];
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
        if ($this->isAddOrEdit()) {
            $this->page_id->Visible = false;
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
        $this->page_id->setVisibility();
        $this->page_name->setVisibility();
        $this->page_content->setVisibility();
        $this->custom_url->setVisibility();
        $this->external_link->setVisibility();
        $this->updated_date->setVisibility();
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

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
            if (($keyValue = Get("custom_url") ?? Key(0) ?? Route(2)) !== null) {
                $this->custom_url->setQueryStringValue($keyValue);
                $this->custom_url->setOldValue($this->custom_url->QueryStringValue);
            } elseif (Post("custom_url") !== null) {
                $this->custom_url->setFormValue(Post("custom_url"));
                $this->custom_url->setOldValue($this->custom_url->FormValue);
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
                if (($keyValue = Get("custom_url") ?? Route("custom_url")) !== null) {
                    $this->custom_url->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->custom_url->CurrentValue = null;
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
                    $this->terminate("wpageslist"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "wpageslist") {
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

        // Check field name 'page_id' first before field var 'x_page_id'
        $val = $CurrentForm->hasValue("page_id") ? $CurrentForm->getValue("page_id") : $CurrentForm->getValue("x_page_id");
        if (!$this->page_id->IsDetailKey) {
            $this->page_id->setFormValue($val);
        }

        // Check field name 'page_name' first before field var 'x_page_name'
        $val = $CurrentForm->hasValue("page_name") ? $CurrentForm->getValue("page_name") : $CurrentForm->getValue("x_page_name");
        if (!$this->page_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->page_name->Visible = false; // Disable update for API request
            } else {
                $this->page_name->setFormValue($val);
            }
        }

        // Check field name 'page_content' first before field var 'x_page_content'
        $val = $CurrentForm->hasValue("page_content") ? $CurrentForm->getValue("page_content") : $CurrentForm->getValue("x_page_content");
        if (!$this->page_content->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->page_content->Visible = false; // Disable update for API request
            } else {
                $this->page_content->setFormValue($val);
            }
        }

        // Check field name 'custom_url' first before field var 'x_custom_url'
        $val = $CurrentForm->hasValue("custom_url") ? $CurrentForm->getValue("custom_url") : $CurrentForm->getValue("x_custom_url");
        if (!$this->custom_url->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->custom_url->Visible = false; // Disable update for API request
            } else {
                $this->custom_url->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_custom_url")) {
            $this->custom_url->setOldValue($CurrentForm->getValue("o_custom_url"));
        }

        // Check field name 'external_link' first before field var 'x_external_link'
        $val = $CurrentForm->hasValue("external_link") ? $CurrentForm->getValue("external_link") : $CurrentForm->getValue("x_external_link");
        if (!$this->external_link->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->external_link->Visible = false; // Disable update for API request
            } else {
                $this->external_link->setFormValue($val);
            }
        }

        // Check field name 'updated_date' first before field var 'x_updated_date'
        $val = $CurrentForm->hasValue("updated_date") ? $CurrentForm->getValue("updated_date") : $CurrentForm->getValue("x_updated_date");
        if (!$this->updated_date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->updated_date->Visible = false; // Disable update for API request
            } else {
                $this->updated_date->setFormValue($val);
            }
            $this->updated_date->CurrentValue = UnFormatDateTime($this->updated_date->CurrentValue, 0);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->page_id->CurrentValue = $this->page_id->FormValue;
        $this->page_name->CurrentValue = $this->page_name->FormValue;
        $this->page_content->CurrentValue = $this->page_content->FormValue;
        $this->custom_url->CurrentValue = $this->custom_url->FormValue;
        $this->external_link->CurrentValue = $this->external_link->FormValue;
        $this->updated_date->CurrentValue = $this->updated_date->FormValue;
        $this->updated_date->CurrentValue = UnFormatDateTime($this->updated_date->CurrentValue, 0);
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
        $this->page_id->setDbValue($row['page_id']);
        $this->page_name->setDbValue($row['page_name']);
        $this->page_content->setDbValue($row['page_content']);
        $this->custom_url->setDbValue($row['custom_url']);
        $this->external_link->setDbValue($row['external_link']);
        $this->updated_date->setDbValue($row['updated_date']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['page_id'] = null;
        $row['page_name'] = null;
        $row['page_content'] = null;
        $row['custom_url'] = null;
        $row['external_link'] = null;
        $row['updated_date'] = null;
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

        // page_id

        // page_name

        // page_content

        // custom_url

        // external_link

        // updated_date
        if ($this->RowType == ROWTYPE_VIEW) {
            // page_id
            $this->page_id->ViewValue = $this->page_id->CurrentValue;
            $this->page_id->ViewCustomAttributes = "";

            // page_name
            $this->page_name->ViewValue = $this->page_name->CurrentValue;
            $this->page_name->ViewCustomAttributes = "";

            // page_content
            $this->page_content->ViewValue = $this->page_content->CurrentValue;
            $this->page_content->ViewCustomAttributes = "";

            // custom_url
            $this->custom_url->ViewValue = $this->custom_url->CurrentValue;
            $this->custom_url->ViewCustomAttributes = "";

            // external_link
            $this->external_link->ViewValue = $this->external_link->CurrentValue;
            $this->external_link->ViewCustomAttributes = "";

            // updated_date
            $this->updated_date->ViewValue = $this->updated_date->CurrentValue;
            $this->updated_date->ViewValue = FormatDateTime($this->updated_date->ViewValue, 0);
            $this->updated_date->ViewCustomAttributes = "";

            // page_id
            $this->page_id->LinkCustomAttributes = "";
            $this->page_id->HrefValue = "";
            $this->page_id->TooltipValue = "";

            // page_name
            $this->page_name->LinkCustomAttributes = "";
            $this->page_name->HrefValue = "";
            $this->page_name->TooltipValue = "";

            // page_content
            $this->page_content->LinkCustomAttributes = "";
            $this->page_content->HrefValue = "";
            $this->page_content->TooltipValue = "";

            // custom_url
            $this->custom_url->LinkCustomAttributes = "";
            $this->custom_url->HrefValue = "";
            $this->custom_url->TooltipValue = "";

            // external_link
            $this->external_link->LinkCustomAttributes = "";
            $this->external_link->HrefValue = "";
            $this->external_link->TooltipValue = "";

            // updated_date
            $this->updated_date->LinkCustomAttributes = "";
            $this->updated_date->HrefValue = "";
            $this->updated_date->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // page_id
            $this->page_id->EditAttrs["class"] = "form-control";
            $this->page_id->EditCustomAttributes = "";
            $this->page_id->EditValue = HtmlEncode($this->page_id->CurrentValue);
            $this->page_id->PlaceHolder = RemoveHtml($this->page_id->caption());

            // page_name
            $this->page_name->EditAttrs["class"] = "form-control";
            $this->page_name->EditCustomAttributes = "";
            if (!$this->page_name->Raw) {
                $this->page_name->CurrentValue = HtmlDecode($this->page_name->CurrentValue);
            }
            $this->page_name->EditValue = HtmlEncode($this->page_name->CurrentValue);
            $this->page_name->PlaceHolder = RemoveHtml($this->page_name->caption());

            // page_content
            $this->page_content->EditAttrs["class"] = "form-control";
            $this->page_content->EditCustomAttributes = "";
            $this->page_content->EditValue = HtmlEncode($this->page_content->CurrentValue);
            $this->page_content->PlaceHolder = RemoveHtml($this->page_content->caption());

            // custom_url
            $this->custom_url->EditAttrs["class"] = "form-control";
            $this->custom_url->EditCustomAttributes = "";
            if (!$this->custom_url->Raw) {
                $this->custom_url->CurrentValue = HtmlDecode($this->custom_url->CurrentValue);
            }
            $this->custom_url->EditValue = HtmlEncode($this->custom_url->CurrentValue);
            $this->custom_url->PlaceHolder = RemoveHtml($this->custom_url->caption());

            // external_link
            $this->external_link->EditAttrs["class"] = "form-control";
            $this->external_link->EditCustomAttributes = "";
            if (!$this->external_link->Raw) {
                $this->external_link->CurrentValue = HtmlDecode($this->external_link->CurrentValue);
            }
            $this->external_link->EditValue = HtmlEncode($this->external_link->CurrentValue);
            $this->external_link->PlaceHolder = RemoveHtml($this->external_link->caption());

            // updated_date

            // Edit refer script

            // page_id
            $this->page_id->LinkCustomAttributes = "";
            $this->page_id->HrefValue = "";

            // page_name
            $this->page_name->LinkCustomAttributes = "";
            $this->page_name->HrefValue = "";

            // page_content
            $this->page_content->LinkCustomAttributes = "";
            $this->page_content->HrefValue = "";

            // custom_url
            $this->custom_url->LinkCustomAttributes = "";
            $this->custom_url->HrefValue = "";

            // external_link
            $this->external_link->LinkCustomAttributes = "";
            $this->external_link->HrefValue = "";

            // updated_date
            $this->updated_date->LinkCustomAttributes = "";
            $this->updated_date->HrefValue = "";
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
        if ($this->page_id->Required) {
            if (!$this->page_id->IsDetailKey && EmptyValue($this->page_id->FormValue)) {
                $this->page_id->addErrorMessage(str_replace("%s", $this->page_id->caption(), $this->page_id->RequiredErrorMessage));
            }
        }
        if ($this->page_name->Required) {
            if (!$this->page_name->IsDetailKey && EmptyValue($this->page_name->FormValue)) {
                $this->page_name->addErrorMessage(str_replace("%s", $this->page_name->caption(), $this->page_name->RequiredErrorMessage));
            }
        }
        if ($this->page_content->Required) {
            if (!$this->page_content->IsDetailKey && EmptyValue($this->page_content->FormValue)) {
                $this->page_content->addErrorMessage(str_replace("%s", $this->page_content->caption(), $this->page_content->RequiredErrorMessage));
            }
        }
        if ($this->custom_url->Required) {
            if (!$this->custom_url->IsDetailKey && EmptyValue($this->custom_url->FormValue)) {
                $this->custom_url->addErrorMessage(str_replace("%s", $this->custom_url->caption(), $this->custom_url->RequiredErrorMessage));
            }
        }
        if ($this->external_link->Required) {
            if (!$this->external_link->IsDetailKey && EmptyValue($this->external_link->FormValue)) {
                $this->external_link->addErrorMessage(str_replace("%s", $this->external_link->caption(), $this->external_link->RequiredErrorMessage));
            }
        }
        if ($this->updated_date->Required) {
            if (!$this->updated_date->IsDetailKey && EmptyValue($this->updated_date->FormValue)) {
                $this->updated_date->addErrorMessage(str_replace("%s", $this->updated_date->caption(), $this->updated_date->RequiredErrorMessage));
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
            $rsnew = [];

            // page_name
            $this->page_name->setDbValueDef($rsnew, $this->page_name->CurrentValue, "", $this->page_name->ReadOnly);

            // page_content
            $this->page_content->setDbValueDef($rsnew, $this->page_content->CurrentValue, "", $this->page_content->ReadOnly);

            // custom_url
            $this->custom_url->setDbValueDef($rsnew, $this->custom_url->CurrentValue, "", $this->custom_url->ReadOnly);

            // external_link
            $this->external_link->setDbValueDef($rsnew, $this->external_link->CurrentValue, null, $this->external_link->ReadOnly);

            // updated_date
            $this->updated_date->CurrentValue = CurrentDateTime();
            $this->updated_date->setDbValueDef($rsnew, $this->updated_date->CurrentValue, CurrentDate());

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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("wpageslist"), "", $this->TableVar, true);
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
