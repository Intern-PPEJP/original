<?php

namespace PHPMaker2021\ppejp_web;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class WOrdersList extends WOrders
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'w_orders';

    // Page object name
    public $PageObjName = "WOrdersList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fw_orderslist";
    public $FormActionName = "k_action";
    public $FormBlankRowName = "k_blankrow";
    public $FormKeyCountName = "key_count";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $CopyUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $ListUrl;

    // Export URLs
    public $ExportPrintUrl;
    public $ExportHtmlUrl;
    public $ExportExcelUrl;
    public $ExportWordUrl;
    public $ExportXmlUrl;
    public $ExportCsvUrl;
    public $ExportPdfUrl;

    // Custom export
    public $ExportExcelCustom = false;
    public $ExportWordCustom = false;
    public $ExportPdfCustom = false;
    public $ExportEmailCustom = false;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

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

        // Table object (w_orders)
        if (!isset($GLOBALS["w_orders"]) || get_class($GLOBALS["w_orders"]) == PROJECT_NAMESPACE . "w_orders") {
            $GLOBALS["w_orders"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Initialize URLs
        $this->ExportPrintUrl = $pageUrl . "export=print";
        $this->ExportExcelUrl = $pageUrl . "export=excel";
        $this->ExportWordUrl = $pageUrl . "export=word";
        $this->ExportPdfUrl = $pageUrl . "export=pdf";
        $this->ExportHtmlUrl = $pageUrl . "export=html";
        $this->ExportXmlUrl = $pageUrl . "export=xml";
        $this->ExportCsvUrl = $pageUrl . "export=csv";
        $this->AddUrl = "wordersadd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "wordersdelete";
        $this->MultiUpdateUrl = "wordersupdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'w_orders');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // List options
        $this->ListOptions = new ListOptions();
        $this->ListOptions->TableVar = $this->TableVar;

        // Export options
        $this->ExportOptions = new ListOptions("div");
        $this->ExportOptions->TagClassName = "ew-export-option";

        // Import options
        $this->ImportOptions = new ListOptions("div");
        $this->ImportOptions->TagClassName = "ew-import-option";

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["addedit"] = new ListOptions("div");
        $this->OtherOptions["addedit"]->TagClassName = "ew-add-edit-option";
        $this->OtherOptions["detail"] = new ListOptions("div");
        $this->OtherOptions["detail"]->TagClassName = "ew-detail-option";
        $this->OtherOptions["action"] = new ListOptions("div");
        $this->OtherOptions["action"]->TagClassName = "ew-action-option";

        // Filter options
        $this->FilterOptions = new ListOptions("div");
        $this->FilterOptions->TagClassName = "ew-filter-option fw_orderslistsrch";

        // List actions
        $this->ListActions = new ListActions();
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
                $doc = new $class(Container("w_orders"));
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
            SaveDebugMessage();
            Redirect(GetUrl($url));
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
		        $this->bukti_pembayaran->OldUploadPath = "files/bukti_pembayaran/";
		        $this->bukti_pembayaran->UploadPath = $this->bukti_pembayaran->OldUploadPath;
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
                        if ($fld->DataType == DATATYPE_MEMO && $fld->MemoMaxLength > 0) {
                            $val = TruncateMemo($val, $fld->MemoMaxLength, $fld->TruncateMemoRemoveHtml);
                        }
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
            $key .= @$ar['order_id'];
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
            $this->order_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->_username->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->created_at->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->updated_at->Visible = false;
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

    // Class variables
    public $ListOptions; // List options
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $OtherOptions; // Other options
    public $FilterOptions; // Filter options
    public $ImportOptions; // Import options
    public $ListActions; // List actions
    public $SelectedCount = 0;
    public $SelectedIndex = 0;
    public $DisplayRecords = 20;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $PageSizes = "10,20,50,-1"; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = ""; // Search WHERE clause
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchRowCount = 0; // For extended search
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $RecordCount = 0; // Record count
    public $EditRowCount;
    public $StartRowCount = 1;
    public $RowCount = 0;
    public $Attrs = []; // Row attributes and cell attributes
    public $RowIndex = 0; // Row index
    public $KeyCount = 0; // Key count
    public $RowAction = ""; // Row action
    public $MultiColumnClass = "col-sm";
    public $MultiColumnEditClass = "w-100";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $MasterRecordExists;
    public $MultiSelectKey;
    public $Command;
    public $RestoreSearch = false;
    public $HashValue; // Hash value
    public $DetailPages;
    public $OldRecordset;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;
        $this->CurrentAction = Param("action"); // Set up current action

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
        $this->order_id->Visible = false;
        $this->nama_peserta->setVisibility();
        $this->_username->setVisibility();
        $this->nama_perusahaan->setVisibility();
        $this->pelatihan_id->setVisibility();
        $this->Biaya->setVisibility();
        $this->tgl_tranfer->setVisibility();
        $this->bukti_pembayaran->setVisibility();
        $this->created_at->Visible = false;
        $this->updated_at->Visible = false;
        $this->status->setVisibility();
        $this->hideFieldsForAddEdit();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Setup other options
        $this->setupOtherOptions();

        // Set up custom action (compatible with old version)
        foreach ($this->CustomActions as $name => $action) {
            $this->ListActions->add($name, $action);
        }

        // Show checkbox column if multiple action
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Select == ACTION_MULTIPLE && $listaction->Allow) {
                $this->ListOptions["checkbox"]->Visible = true;
                break;
            }
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->_username);
        $this->setupLookupOptions($this->pelatihan_id);

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $filter = "";

        // Get command
        $this->Command = strtolower(Get("cmd"));
        if ($this->isPageRequest()) {
            // Process list action first
            if ($this->processListAction()) { // Ajax request
                $this->terminate();
                return;
            }

            // Set up records per page
            $this->setupDisplayRecords();

            // Handle reset command
            $this->resetCmd();

            // Set up Breadcrumb
            if (!$this->isExport()) {
                $this->setupBreadcrumb();
            }

            // Hide list options
            if ($this->isExport()) {
                $this->ListOptions->hideAllOptions(["sequence"]);
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            } elseif ($this->isGridAdd() || $this->isGridEdit()) {
                $this->ListOptions->hideAllOptions();
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            }

            // Hide options
            if ($this->isExport() || $this->CurrentAction) {
                $this->ExportOptions->hideAllOptions();
                $this->FilterOptions->hideAllOptions();
                $this->ImportOptions->hideAllOptions();
            }

            // Hide other options
            if ($this->isExport()) {
                $this->OtherOptions->hideAllOptions();
            }

            // Get default search criteria
            AddFilter($this->DefaultSearchWhere, $this->advancedSearchWhere(true));

            // Get and validate search values for advanced search
            $this->loadSearchValues(); // Get search values

            // Process filter list
            if ($this->processFilterList()) {
                $this->terminate();
                return;
            }
            if (!$this->validateSearch()) {
                // Nothing to do
            }

            // Restore search parms from Session if not searching / reset / export
            if (($this->isExport() || $this->Command != "search" && $this->Command != "reset" && $this->Command != "resetall") && $this->Command != "json" && $this->checkSearchParms()) {
                $this->restoreSearchParms();
            }

            // Call Recordset SearchValidated event
            $this->recordsetSearchValidated();

            // Set up sorting order
            $this->setupSortOrder();

            // Get search criteria for advanced search
            if (!$this->hasInvalidFields()) {
                $srchAdvanced = $this->advancedSearchWhere();
            }
        }

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 20; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Load Sorting Order
        if ($this->Command != "json") {
            $this->loadSortOrder();
        }

        // Load search default if no existing search criteria
        if (!$this->checkSearchParms()) {
            // Load advanced search from default
            if ($this->loadAdvancedSearchDefault()) {
                $srchAdvanced = $this->advancedSearchWhere();
            }
        }

        // Restore search settings from Session
        if (!$this->hasInvalidFields()) {
            $this->loadAdvancedSearch();
        }

        // Build search criteria
        AddFilter($this->SearchWhere, $srchAdvanced);
        AddFilter($this->SearchWhere, $srchBasic);

        // Call Recordset_Searching event
        $this->recordsetSearching($this->SearchWhere);

        // Save search criteria
        if ($this->Command == "search" && !$this->RestoreSearch) {
            $this->setSearchWhere($this->SearchWhere); // Save to Session
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->Command != "json") {
            $this->SearchWhere = $this->getSearchWhere();
        }

        // Build filter
        $filter = "";
        if (!$Security->canList()) {
            $filter = "(0=1)"; // Filter all records
        }
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $filter;
        } else {
            $this->setSessionWhere($filter);
            $this->CurrentFilter = "";
        }
        if ($this->isGridAdd()) {
            $this->CurrentFilter = "0=1";
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->GridAddRowCount;
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            if ($this->DisplayRecords <= 0 || ($this->isExport() && $this->ExportAll)) { // Display all records
                $this->DisplayRecords = $this->TotalRecords;
            }
            if (!($this->isExport() && $this->ExportAll)) { // Set up start record position
                $this->setupStartRecord();
            }
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);

            // Set no record found message
            if (!$this->CurrentAction && $this->TotalRecords == 0) {
                if (!$Security->canList()) {
                    $this->setWarningMessage(DeniedMessage());
                }
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            }
        }

        // Search options
        $this->setupSearchOptions();

        // Set up search panel class
        if ($this->SearchWhere != "") {
            AppendClass($this->SearchPanelClass, "show");
        }

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset);
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows, "totalRecordCount" => $this->TotalRecords]);
            $this->terminate(true);
            return;
        }

        // Set up pager
        $this->Pager = new PrevNextPager($this->StartRecord, $this->getRecordsPerPage(), $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

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

    // Set up number of records displayed per page
    protected function setupDisplayRecords()
    {
        $wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
        if ($wrk != "") {
            if (is_numeric($wrk)) {
                $this->DisplayRecords = (int)$wrk;
            } else {
                if (SameText($wrk, "all")) { // Display all records
                    $this->DisplayRecords = -1;
                } else {
                    $this->DisplayRecords = 20; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Build filter for all keys
    protected function buildKeyFilter()
    {
        global $CurrentForm;
        $wrkFilter = "";

        // Update row index and get row key
        $rowindex = 1;
        $CurrentForm->Index = $rowindex;
        $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        while ($thisKey != "") {
            $this->setKey($thisKey);
            if ($this->OldKey != "") {
                $filter = $this->getRecordFilter();
                if ($wrkFilter != "") {
                    $wrkFilter .= " OR ";
                }
                $wrkFilter .= $filter;
            } else {
                $wrkFilter = "0=1";
                break;
            }

            // Update row index and get row key
            $rowindex++; // Next row
            $CurrentForm->Index = $rowindex;
            $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        }
        return $wrkFilter;
    }

    // Get list of filters
    public function getFilterList()
    {
        global $UserProfile;

        // Initialize
        $filterList = "";
        $savedFilterList = "";
        $filterList = Concat($filterList, $this->order_id->AdvancedSearch->toJson(), ","); // Field order_id
        $filterList = Concat($filterList, $this->nama_peserta->AdvancedSearch->toJson(), ","); // Field nama_peserta
        $filterList = Concat($filterList, $this->_username->AdvancedSearch->toJson(), ","); // Field username
        $filterList = Concat($filterList, $this->nama_perusahaan->AdvancedSearch->toJson(), ","); // Field nama_perusahaan
        $filterList = Concat($filterList, $this->pelatihan_id->AdvancedSearch->toJson(), ","); // Field pelatihan_id
        $filterList = Concat($filterList, $this->Biaya->AdvancedSearch->toJson(), ","); // Field Biaya
        $filterList = Concat($filterList, $this->tgl_tranfer->AdvancedSearch->toJson(), ","); // Field tgl_tranfer
        $filterList = Concat($filterList, $this->bukti_pembayaran->AdvancedSearch->toJson(), ","); // Field bukti_pembayaran
        $filterList = Concat($filterList, $this->created_at->AdvancedSearch->toJson(), ","); // Field created_at
        $filterList = Concat($filterList, $this->updated_at->AdvancedSearch->toJson(), ","); // Field updated_at
        $filterList = Concat($filterList, $this->status->AdvancedSearch->toJson(), ","); // Field status

        // Return filter list in JSON
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Process filter list
    protected function processFilterList()
    {
        global $UserProfile;
        if (Post("ajax") == "savefilters") { // Save filter request (Ajax)
            $filters = Post("filters");
            $UserProfile->setSearchFilters(CurrentUserName(), "fw_orderslistsrch", $filters);
            WriteJson([["success" => true]]); // Success
            return true;
        } elseif (Post("cmd") == "resetfilter") {
            $this->restoreFilterList();
        }
        return false;
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd") !== "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter"), true);
        $this->Command = "search";

        // Field order_id
        $this->order_id->AdvancedSearch->SearchValue = @$filter["x_order_id"];
        $this->order_id->AdvancedSearch->SearchOperator = @$filter["z_order_id"];
        $this->order_id->AdvancedSearch->SearchCondition = @$filter["v_order_id"];
        $this->order_id->AdvancedSearch->SearchValue2 = @$filter["y_order_id"];
        $this->order_id->AdvancedSearch->SearchOperator2 = @$filter["w_order_id"];
        $this->order_id->AdvancedSearch->save();

        // Field nama_peserta
        $this->nama_peserta->AdvancedSearch->SearchValue = @$filter["x_nama_peserta"];
        $this->nama_peserta->AdvancedSearch->SearchOperator = @$filter["z_nama_peserta"];
        $this->nama_peserta->AdvancedSearch->SearchCondition = @$filter["v_nama_peserta"];
        $this->nama_peserta->AdvancedSearch->SearchValue2 = @$filter["y_nama_peserta"];
        $this->nama_peserta->AdvancedSearch->SearchOperator2 = @$filter["w_nama_peserta"];
        $this->nama_peserta->AdvancedSearch->save();

        // Field username
        $this->_username->AdvancedSearch->SearchValue = @$filter["x__username"];
        $this->_username->AdvancedSearch->SearchOperator = @$filter["z__username"];
        $this->_username->AdvancedSearch->SearchCondition = @$filter["v__username"];
        $this->_username->AdvancedSearch->SearchValue2 = @$filter["y__username"];
        $this->_username->AdvancedSearch->SearchOperator2 = @$filter["w__username"];
        $this->_username->AdvancedSearch->save();

        // Field nama_perusahaan
        $this->nama_perusahaan->AdvancedSearch->SearchValue = @$filter["x_nama_perusahaan"];
        $this->nama_perusahaan->AdvancedSearch->SearchOperator = @$filter["z_nama_perusahaan"];
        $this->nama_perusahaan->AdvancedSearch->SearchCondition = @$filter["v_nama_perusahaan"];
        $this->nama_perusahaan->AdvancedSearch->SearchValue2 = @$filter["y_nama_perusahaan"];
        $this->nama_perusahaan->AdvancedSearch->SearchOperator2 = @$filter["w_nama_perusahaan"];
        $this->nama_perusahaan->AdvancedSearch->save();

        // Field pelatihan_id
        $this->pelatihan_id->AdvancedSearch->SearchValue = @$filter["x_pelatihan_id"];
        $this->pelatihan_id->AdvancedSearch->SearchOperator = @$filter["z_pelatihan_id"];
        $this->pelatihan_id->AdvancedSearch->SearchCondition = @$filter["v_pelatihan_id"];
        $this->pelatihan_id->AdvancedSearch->SearchValue2 = @$filter["y_pelatihan_id"];
        $this->pelatihan_id->AdvancedSearch->SearchOperator2 = @$filter["w_pelatihan_id"];
        $this->pelatihan_id->AdvancedSearch->save();

        // Field Biaya
        $this->Biaya->AdvancedSearch->SearchValue = @$filter["x_Biaya"];
        $this->Biaya->AdvancedSearch->SearchOperator = @$filter["z_Biaya"];
        $this->Biaya->AdvancedSearch->SearchCondition = @$filter["v_Biaya"];
        $this->Biaya->AdvancedSearch->SearchValue2 = @$filter["y_Biaya"];
        $this->Biaya->AdvancedSearch->SearchOperator2 = @$filter["w_Biaya"];
        $this->Biaya->AdvancedSearch->save();

        // Field tgl_tranfer
        $this->tgl_tranfer->AdvancedSearch->SearchValue = @$filter["x_tgl_tranfer"];
        $this->tgl_tranfer->AdvancedSearch->SearchOperator = @$filter["z_tgl_tranfer"];
        $this->tgl_tranfer->AdvancedSearch->SearchCondition = @$filter["v_tgl_tranfer"];
        $this->tgl_tranfer->AdvancedSearch->SearchValue2 = @$filter["y_tgl_tranfer"];
        $this->tgl_tranfer->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_tranfer"];
        $this->tgl_tranfer->AdvancedSearch->save();

        // Field bukti_pembayaran
        $this->bukti_pembayaran->AdvancedSearch->SearchValue = @$filter["x_bukti_pembayaran"];
        $this->bukti_pembayaran->AdvancedSearch->SearchOperator = @$filter["z_bukti_pembayaran"];
        $this->bukti_pembayaran->AdvancedSearch->SearchCondition = @$filter["v_bukti_pembayaran"];
        $this->bukti_pembayaran->AdvancedSearch->SearchValue2 = @$filter["y_bukti_pembayaran"];
        $this->bukti_pembayaran->AdvancedSearch->SearchOperator2 = @$filter["w_bukti_pembayaran"];
        $this->bukti_pembayaran->AdvancedSearch->save();

        // Field created_at
        $this->created_at->AdvancedSearch->SearchValue = @$filter["x_created_at"];
        $this->created_at->AdvancedSearch->SearchOperator = @$filter["z_created_at"];
        $this->created_at->AdvancedSearch->SearchCondition = @$filter["v_created_at"];
        $this->created_at->AdvancedSearch->SearchValue2 = @$filter["y_created_at"];
        $this->created_at->AdvancedSearch->SearchOperator2 = @$filter["w_created_at"];
        $this->created_at->AdvancedSearch->save();

        // Field updated_at
        $this->updated_at->AdvancedSearch->SearchValue = @$filter["x_updated_at"];
        $this->updated_at->AdvancedSearch->SearchOperator = @$filter["z_updated_at"];
        $this->updated_at->AdvancedSearch->SearchCondition = @$filter["v_updated_at"];
        $this->updated_at->AdvancedSearch->SearchValue2 = @$filter["y_updated_at"];
        $this->updated_at->AdvancedSearch->SearchOperator2 = @$filter["w_updated_at"];
        $this->updated_at->AdvancedSearch->save();

        // Field status
        $this->status->AdvancedSearch->SearchValue = @$filter["x_status"];
        $this->status->AdvancedSearch->SearchOperator = @$filter["z_status"];
        $this->status->AdvancedSearch->SearchCondition = @$filter["v_status"];
        $this->status->AdvancedSearch->SearchValue2 = @$filter["y_status"];
        $this->status->AdvancedSearch->SearchOperator2 = @$filter["w_status"];
        $this->status->AdvancedSearch->save();
    }

    // Advanced search WHERE clause based on QueryString
    protected function advancedSearchWhere($default = false)
    {
        global $Security;
        $where = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $this->buildSearchSql($where, $this->order_id, $default, false); // order_id
        $this->buildSearchSql($where, $this->nama_peserta, $default, false); // nama_peserta
        $this->buildSearchSql($where, $this->_username, $default, false); // username
        $this->buildSearchSql($where, $this->nama_perusahaan, $default, false); // nama_perusahaan
        $this->buildSearchSql($where, $this->pelatihan_id, $default, false); // pelatihan_id
        $this->buildSearchSql($where, $this->Biaya, $default, false); // Biaya
        $this->buildSearchSql($where, $this->tgl_tranfer, $default, false); // tgl_tranfer
        $this->buildSearchSql($where, $this->bukti_pembayaran, $default, false); // bukti_pembayaran
        $this->buildSearchSql($where, $this->created_at, $default, false); // created_at
        $this->buildSearchSql($where, $this->updated_at, $default, false); // updated_at
        $this->buildSearchSql($where, $this->status, $default, false); // status

        // Set up search parm
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->order_id->AdvancedSearch->save(); // order_id
            $this->nama_peserta->AdvancedSearch->save(); // nama_peserta
            $this->_username->AdvancedSearch->save(); // username
            $this->nama_perusahaan->AdvancedSearch->save(); // nama_perusahaan
            $this->pelatihan_id->AdvancedSearch->save(); // pelatihan_id
            $this->Biaya->AdvancedSearch->save(); // Biaya
            $this->tgl_tranfer->AdvancedSearch->save(); // tgl_tranfer
            $this->bukti_pembayaran->AdvancedSearch->save(); // bukti_pembayaran
            $this->created_at->AdvancedSearch->save(); // created_at
            $this->updated_at->AdvancedSearch->save(); // updated_at
            $this->status->AdvancedSearch->save(); // status
        }
        return $where;
    }

    // Build search SQL
    protected function buildSearchSql(&$where, &$fld, $default, $multiValue)
    {
        $fldParm = $fld->Param;
        $fldVal = ($default) ? $fld->AdvancedSearch->SearchValueDefault : $fld->AdvancedSearch->SearchValue;
        $fldOpr = ($default) ? $fld->AdvancedSearch->SearchOperatorDefault : $fld->AdvancedSearch->SearchOperator;
        $fldCond = ($default) ? $fld->AdvancedSearch->SearchConditionDefault : $fld->AdvancedSearch->SearchCondition;
        $fldVal2 = ($default) ? $fld->AdvancedSearch->SearchValue2Default : $fld->AdvancedSearch->SearchValue2;
        $fldOpr2 = ($default) ? $fld->AdvancedSearch->SearchOperator2Default : $fld->AdvancedSearch->SearchOperator2;
        $wrk = "";
        if (is_array($fldVal)) {
            $fldVal = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal);
        }
        if (is_array($fldVal2)) {
            $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
        }
        $fldOpr = strtoupper(trim($fldOpr));
        if ($fldOpr == "") {
            $fldOpr = "=";
        }
        $fldOpr2 = strtoupper(trim($fldOpr2));
        if ($fldOpr2 == "") {
            $fldOpr2 = "=";
        }
        if (Config("SEARCH_MULTI_VALUE_OPTION") == 1 || !IsMultiSearchOperator($fldOpr)) {
            $multiValue = false;
        }
        if ($multiValue) {
            $wrk1 = ($fldVal != "") ? GetMultiSearchSql($fld, $fldOpr, $fldVal, $this->Dbid) : ""; // Field value 1
            $wrk2 = ($fldVal2 != "") ? GetMultiSearchSql($fld, $fldOpr2, $fldVal2, $this->Dbid) : ""; // Field value 2
            $wrk = $wrk1; // Build final SQL
            if ($wrk2 != "") {
                $wrk = ($wrk != "") ? "($wrk) $fldCond ($wrk2)" : $wrk2;
            }
        } else {
            $fldVal = $this->convertSearchValue($fld, $fldVal);
            $fldVal2 = $this->convertSearchValue($fld, $fldVal2);
            $wrk = GetSearchSql($fld, $fldVal, $fldOpr, $fldCond, $fldVal2, $fldOpr2, $this->Dbid);
        }
        AddFilter($where, $wrk);
    }

    // Convert search value
    protected function convertSearchValue(&$fld, $fldVal)
    {
        if ($fldVal == Config("NULL_VALUE") || $fldVal == Config("NOT_NULL_VALUE")) {
            return $fldVal;
        }
        $value = $fldVal;
        if ($fld->isBoolean()) {
            if ($fldVal != "") {
                $value = (SameText($fldVal, "1") || SameText($fldVal, "y") || SameText($fldVal, "t")) ? $fld->TrueValue : $fld->FalseValue;
            }
        } elseif ($fld->DataType == DATATYPE_DATE || $fld->DataType == DATATYPE_TIME) {
            if ($fldVal != "") {
                $value = UnFormatDateTime($fldVal, $fld->DateTimeFormat);
            }
        }
        return $value;
    }

    // Check if search parm exists
    protected function checkSearchParms()
    {
        if ($this->order_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nama_peserta->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->_username->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nama_perusahaan->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->pelatihan_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->Biaya->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->tgl_tranfer->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->bukti_pembayaran->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->created_at->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->updated_at->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->status->AdvancedSearch->issetSession()) {
            return true;
        }
        return false;
    }

    // Clear all search parameters
    protected function resetSearchParms()
    {
        // Clear search WHERE clause
        $this->SearchWhere = "";
        $this->setSearchWhere($this->SearchWhere);

        // Clear advanced search parameters
        $this->resetAdvancedSearchParms();
    }

    // Load advanced search default values
    protected function loadAdvancedSearchDefault()
    {
        return false;
    }

    // Clear all advanced search parameters
    protected function resetAdvancedSearchParms()
    {
                $this->order_id->AdvancedSearch->unsetSession();
                $this->nama_peserta->AdvancedSearch->unsetSession();
                $this->_username->AdvancedSearch->unsetSession();
                $this->nama_perusahaan->AdvancedSearch->unsetSession();
                $this->pelatihan_id->AdvancedSearch->unsetSession();
                $this->Biaya->AdvancedSearch->unsetSession();
                $this->tgl_tranfer->AdvancedSearch->unsetSession();
                $this->bukti_pembayaran->AdvancedSearch->unsetSession();
                $this->created_at->AdvancedSearch->unsetSession();
                $this->updated_at->AdvancedSearch->unsetSession();
                $this->status->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore advanced search values
                $this->order_id->AdvancedSearch->load();
                $this->nama_peserta->AdvancedSearch->load();
                $this->_username->AdvancedSearch->load();
                $this->nama_perusahaan->AdvancedSearch->load();
                $this->pelatihan_id->AdvancedSearch->load();
                $this->Biaya->AdvancedSearch->load();
                $this->tgl_tranfer->AdvancedSearch->load();
                $this->bukti_pembayaran->AdvancedSearch->load();
                $this->created_at->AdvancedSearch->load();
                $this->updated_at->AdvancedSearch->load();
                $this->status->AdvancedSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->nama_peserta); // nama_peserta
            $this->updateSort($this->_username); // username
            $this->updateSort($this->nama_perusahaan); // nama_perusahaan
            $this->updateSort($this->pelatihan_id); // pelatihan_id
            $this->updateSort($this->Biaya); // Biaya
            $this->updateSort($this->tgl_tranfer); // tgl_tranfer
            $this->updateSort($this->bukti_pembayaran); // bukti_pembayaran
            $this->updateSort($this->status); // status
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($useDefaultSort) {
                    $orderBy = $this->getSqlOrderBy();
                    $this->setSessionOrderBy($orderBy);
                } else {
                    $this->setSessionOrderBy("");
                }
            }
        }
    }

    // Reset command
    // - cmd=reset (Reset search parameters)
    // - cmd=resetall (Reset search and master/detail parameters)
    // - cmd=resetsort (Reset sort parameters)
    protected function resetCmd()
    {
        // Check if reset command
        if (StartsString("reset", $this->Command)) {
            // Reset search criteria
            if ($this->Command == "reset" || $this->Command == "resetall") {
                $this->resetSearchParms();
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->order_id->setSort("");
                $this->nama_peserta->setSort("");
                $this->_username->setSort("");
                $this->nama_perusahaan->setSort("");
                $this->pelatihan_id->setSort("");
                $this->Biaya->setSort("");
                $this->tgl_tranfer->setSort("");
                $this->bukti_pembayaran->setSort("");
                $this->created_at->setSort("");
                $this->updated_at->setSort("");
                $this->status->setSort("");
            }

            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Set up list options
    protected function setupListOptions()
    {
        global $Security, $Language;

        // Add group option item
        $item = &$this->ListOptions->add($this->ListOptions->GroupOptionName);
        $item->Body = "";
        $item->OnLeft = false;
        $item->Visible = false;

        // List actions
        $item = &$this->ListOptions->add("listactions");
        $item->CssClass = "text-nowrap";
        $item->OnLeft = false;
        $item->Visible = false;
        $item->ShowInButtonGroup = false;
        $item->ShowInDropDown = false;

        // "checkbox"
        $item = &$this->ListOptions->add("checkbox");
        $item->Visible = false;
        $item->OnLeft = false;
        $item->Header = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" name=\"key\" id=\"key\" class=\"custom-control-input\" onclick=\"ew.selectAllKey(this);\"><label class=\"custom-control-label\" for=\"key\"></label></div>";
        $item->ShowInDropDown = false;
        $item->ShowInButtonGroup = false;

        // "sequence"
        $item = &$this->ListOptions->add("sequence");
        $item->CssClass = "text-nowrap";
        $item->Visible = true;
        $item->OnLeft = true; // Always on left
        $item->ShowInDropDown = false;
        $item->ShowInButtonGroup = false;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = false;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = false;
        if ($this->ListOptions->UseButtonGroup && IsMobile()) {
            $this->ListOptions->UseDropDownButton = true;
        }

        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $this->setupListOptionsExt();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Render list options
    public function renderListOptions()
    {
        global $Security, $Language, $CurrentForm;
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();

        // "sequence"
        $opt = $this->ListOptions["sequence"];
        $opt->Body = FormatSequenceNumber($this->RecordCount);
        $pageUrl = $this->pageUrl();
        if ($this->CurrentMode == "view") { // View mode
        } // End View mode

        // Set up list action buttons
        $opt = $this->ListOptions["listactions"];
        if ($opt && !$this->isExport() && !$this->CurrentAction) {
            $body = "";
            $links = [];
            foreach ($this->ListActions->Items as $listaction) {
                if ($listaction->Select == ACTION_SINGLE && $listaction->Allow) {
                    $action = $listaction->Action;
                    $caption = $listaction->Caption;
                    $icon = ($listaction->Icon != "") ? "<i class=\"" . HtmlEncode(str_replace(" ew-icon", "", $listaction->Icon)) . "\" data-caption=\"" . HtmlTitle($caption) . "\"></i> " : "";
                    $links[] = "<li><a class=\"dropdown-item ew-action ew-list-action\" data-action=\"" . HtmlEncode($action) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({key:" . $this->keyToJson(true) . "}," . $listaction->toJson(true) . "));\">" . $icon . $listaction->Caption . "</a></li>";
                    if (count($links) == 1) { // Single button
                        $body = "<a class=\"ew-action ew-list-action\" data-action=\"" . HtmlEncode($action) . "\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({key:" . $this->keyToJson(true) . "}," . $listaction->toJson(true) . "));\">" . $icon . $listaction->Caption . "</a>";
                    }
                }
            }
            if (count($links) > 1) { // More than one buttons, use dropdown
                $body = "<button class=\"dropdown-toggle btn btn-default ew-actions\" title=\"" . HtmlTitle($Language->phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->phrase("ListActionButton") . "</button>";
                $content = "";
                foreach ($links as $link) {
                    $content .= "<li>" . $link . "</li>";
                }
                $body .= "<ul class=\"dropdown-menu" . ($opt->OnLeft ? "" : " dropdown-menu-right") . "\">" . $content . "</ul>";
                $body = "<div class=\"btn-group btn-group-sm\">" . $body . "</div>";
            }
            if (count($links) > 0) {
                $opt->Body = $body;
                $opt->Visible = true;
            }
        }

        // "checkbox"
        $opt = $this->ListOptions["checkbox"];
        $opt->Body = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"custom-control-input ew-multi-select\" value=\"" . HtmlEncode($this->order_id->CurrentValue) . "\" onclick=\"ew.clickMultiCheckbox(event);\"><label class=\"custom-control-label\" for=\"key_m_" . $this->RowCount . "\"></label></div>";
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["addedit"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("AddLink"));
        $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        $option = $options["action"];

        // Set up options default
        foreach ($options as $option) {
            $option->UseDropDownButton = false;
            $option->UseButtonGroup = true;
            //$option->ButtonClass = ""; // Class for button group
            $item = &$option->add($option->GroupOptionName);
            $item->Body = "";
            $item->Visible = false;
        }
        $options["addedit"]->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
        $options["action"]->DropDownButtonPhrase = $Language->phrase("ButtonActions");

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fw_orderslistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fw_orderslistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->add($this->FilterOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];
        // Set up list action buttons
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Select == ACTION_MULTIPLE) {
                $item = &$option->add("custom_" . $listaction->Action);
                $caption = $listaction->Caption;
                $icon = ($listaction->Icon != "") ? '<i class="' . HtmlEncode($listaction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fw_orderslist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
                $item->Visible = $listaction->Allow;
            }
        }

        // Hide grid edit and other options
        if ($this->TotalRecords <= 0) {
            $option = $options["addedit"];
            $item = $option["gridedit"];
            if ($item) {
                $item->Visible = false;
            }
            $option = $options["action"];
            $option->hideAllOptions();
        }
    }

    // Process list action
    protected function processListAction()
    {
        global $Language, $Security;
        $userlist = "";
        $user = "";
        $filter = $this->getFilterFromRecordKeys();
        $userAction = Post("useraction", "");
        if ($filter != "" && $userAction != "") {
            // Check permission first
            $actionCaption = $userAction;
            if (array_key_exists($userAction, $this->ListActions->Items)) {
                $actionCaption = $this->ListActions[$userAction]->Caption;
                if (!$this->ListActions[$userAction]->Allow) {
                    $errmsg = str_replace('%s', $actionCaption, $Language->phrase("CustomActionNotAllowed"));
                    if (Post("ajax") == $userAction) { // Ajax
                        echo "<p class=\"text-danger\">" . $errmsg . "</p>";
                        return true;
                    } else {
                        $this->setFailureMessage($errmsg);
                        return false;
                    }
                }
            }
            $this->CurrentFilter = $filter;
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = LoadRecordset($sql, $conn, \PDO::FETCH_ASSOC);
            $this->CurrentAction = $userAction;

            // Call row action event
            if ($rs) {
                $conn->beginTransaction();
                $this->SelectedCount = $rs->recordCount();
                $this->SelectedIndex = 0;
                while (!$rs->EOF) {
                    $this->SelectedIndex++;
                    $row = $rs->fields;
                    $processed = $this->rowCustomAction($userAction, $row);
                    if (!$processed) {
                        break;
                    }
                    $rs->moveNext();
                }
                if ($processed) {
                    $conn->commit(); // Commit the changes
                    if ($this->getSuccessMessage() == "" && !ob_get_length()) { // No output
                        $this->setSuccessMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionCompleted"))); // Set up success message
                    }
                } else {
                    $conn->rollback(); // Rollback changes

                    // Set up error message
                    if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                        // Use the message, do nothing
                    } elseif ($this->CancelMessage != "") {
                        $this->setFailureMessage($this->CancelMessage);
                        $this->CancelMessage = "";
                    } else {
                        $this->setFailureMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionFailed")));
                    }
                }
            }
            if ($rs) {
                $rs->close();
            }
            $this->CurrentAction = ""; // Clear action
            if (Post("ajax") == $userAction) { // Ajax
                if ($this->getSuccessMessage() != "") {
                    echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
                    $this->clearSuccessMessage(); // Clear message
                }
                if ($this->getFailureMessage() != "") {
                    echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
                    $this->clearFailureMessage(); // Clear message
                }
                return true;
            }
        }
        return false; // Not ajax request
    }

    // Set up list options (extended codes)
    protected function setupListOptionsExt()
    {
    }

    // Render list options (extended codes)
    protected function renderListOptionsExt()
    {
    }

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;

        // order_id
        if (!$this->isAddOrEdit() && $this->order_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->order_id->AdvancedSearch->SearchValue != "" || $this->order_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // nama_peserta
        if (!$this->isAddOrEdit() && $this->nama_peserta->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->nama_peserta->AdvancedSearch->SearchValue != "" || $this->nama_peserta->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // username
        if (!$this->isAddOrEdit() && $this->_username->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->_username->AdvancedSearch->SearchValue != "" || $this->_username->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // nama_perusahaan
        if (!$this->isAddOrEdit() && $this->nama_perusahaan->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->nama_perusahaan->AdvancedSearch->SearchValue != "" || $this->nama_perusahaan->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // pelatihan_id
        if (!$this->isAddOrEdit() && $this->pelatihan_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->pelatihan_id->AdvancedSearch->SearchValue != "" || $this->pelatihan_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // Biaya
        if (!$this->isAddOrEdit() && $this->Biaya->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->Biaya->AdvancedSearch->SearchValue != "" || $this->Biaya->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // tgl_tranfer
        if (!$this->isAddOrEdit() && $this->tgl_tranfer->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->tgl_tranfer->AdvancedSearch->SearchValue != "" || $this->tgl_tranfer->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // bukti_pembayaran
        if (!$this->isAddOrEdit() && $this->bukti_pembayaran->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->bukti_pembayaran->AdvancedSearch->SearchValue != "" || $this->bukti_pembayaran->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // created_at
        if (!$this->isAddOrEdit() && $this->created_at->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->created_at->AdvancedSearch->SearchValue != "" || $this->created_at->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // updated_at
        if (!$this->isAddOrEdit() && $this->updated_at->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->updated_at->AdvancedSearch->SearchValue != "" || $this->updated_at->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // status
        if (!$this->isAddOrEdit() && $this->status->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->status->AdvancedSearch->SearchValue != "" || $this->status->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        return $hasValue;
    }

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $stmt = $sql->execute();
        $rs = new Recordset($stmt, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
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
        $this->order_id->setDbValue($row['order_id']);
        $this->nama_peserta->setDbValue($row['nama_peserta']);
        $this->_username->setDbValue($row['username']);
        $this->nama_perusahaan->setDbValue($row['nama_perusahaan']);
        $this->pelatihan_id->setDbValue($row['pelatihan_id']);
        $this->Biaya->setDbValue($row['Biaya']);
        $this->tgl_tranfer->setDbValue($row['tgl_tranfer']);
        $this->bukti_pembayaran->Upload->DbValue = $row['bukti_pembayaran'];
        $this->bukti_pembayaran->setDbValue($this->bukti_pembayaran->Upload->DbValue);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
        $this->status->setDbValue($row['status']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['order_id'] = null;
        $row['nama_peserta'] = null;
        $row['username'] = null;
        $row['nama_perusahaan'] = null;
        $row['pelatihan_id'] = null;
        $row['Biaya'] = null;
        $row['tgl_tranfer'] = null;
        $row['bukti_pembayaran'] = null;
        $row['created_at'] = null;
        $row['updated_at'] = null;
        $row['status'] = null;
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
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->InlineEditUrl = $this->getInlineEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->InlineCopyUrl = $this->getInlineCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // order_id

        // nama_peserta

        // username

        // nama_perusahaan

        // pelatihan_id

        // Biaya

        // tgl_tranfer

        // bukti_pembayaran

        // created_at

        // updated_at

        // status
        if ($this->RowType == ROWTYPE_VIEW) {
            // order_id
            $this->order_id->ViewValue = $this->order_id->CurrentValue;
            $this->order_id->ViewCustomAttributes = "";

            // nama_peserta
            $this->nama_peserta->ViewValue = $this->nama_peserta->CurrentValue;
            $this->nama_peserta->ViewCustomAttributes = "";

            // username
            $curVal = trim(strval($this->_username->CurrentValue));
            if ($curVal != "") {
                $this->_username->ViewValue = $this->_username->lookupCacheOption($curVal);
                if ($this->_username->ViewValue === null) { // Lookup from database
                    $filterWrk = "`user_email`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->_username->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->_username->Lookup->renderViewRow($rswrk[0]);
                        $this->_username->ViewValue = $this->_username->displayValue($arwrk);
                    } else {
                        $this->_username->ViewValue = $this->_username->CurrentValue;
                    }
                }
            } else {
                $this->_username->ViewValue = null;
            }
            $this->_username->ViewCustomAttributes = "";

            // nama_perusahaan
            $this->nama_perusahaan->ViewValue = $this->nama_perusahaan->CurrentValue;
            $this->nama_perusahaan->ViewCustomAttributes = "";

            // pelatihan_id
            $curVal = trim(strval($this->pelatihan_id->CurrentValue));
            if ($curVal != "") {
                $this->pelatihan_id->ViewValue = $this->pelatihan_id->lookupCacheOption($curVal);
                if ($this->pelatihan_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "`pelatihan_id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "`Activated` = 'Y'";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->pelatihan_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->pelatihan_id->Lookup->renderViewRow($rswrk[0]);
                        $this->pelatihan_id->ViewValue = $this->pelatihan_id->displayValue($arwrk);
                    } else {
                        $this->pelatihan_id->ViewValue = $this->pelatihan_id->CurrentValue;
                    }
                }
            } else {
                $this->pelatihan_id->ViewValue = null;
            }
            $this->pelatihan_id->ViewCustomAttributes = "";

            // Biaya
            $this->Biaya->ViewValue = $this->Biaya->CurrentValue;
            $this->Biaya->ViewCustomAttributes = "";

            // tgl_tranfer
            $this->tgl_tranfer->ViewValue = $this->tgl_tranfer->CurrentValue;
            $this->tgl_tranfer->ViewValue = FormatDateTime($this->tgl_tranfer->ViewValue, 0);
            $this->tgl_tranfer->ViewCustomAttributes = "";

            // bukti_pembayaran
            $this->bukti_pembayaran->UploadPath = "files/bukti_pembayaran/";
            if (!EmptyValue($this->bukti_pembayaran->Upload->DbValue)) {
                $this->bukti_pembayaran->ImageWidth = 200;
                $this->bukti_pembayaran->ImageHeight = 0;
                $this->bukti_pembayaran->ImageAlt = $this->bukti_pembayaran->alt();
                $this->bukti_pembayaran->ViewValue = $this->bukti_pembayaran->Upload->DbValue;
            } else {
                $this->bukti_pembayaran->ViewValue = "";
            }
            $this->bukti_pembayaran->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // status
            if (strval($this->status->CurrentValue) != "") {
                $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
            } else {
                $this->status->ViewValue = null;
            }
            $this->status->ViewCustomAttributes = "";

            // nama_peserta
            $this->nama_peserta->LinkCustomAttributes = "";
            $this->nama_peserta->HrefValue = "";
            $this->nama_peserta->TooltipValue = "";

            // username
            $this->_username->LinkCustomAttributes = "";
            $this->_username->HrefValue = "";
            $this->_username->TooltipValue = "";

            // nama_perusahaan
            $this->nama_perusahaan->LinkCustomAttributes = "";
            $this->nama_perusahaan->HrefValue = "";
            $this->nama_perusahaan->TooltipValue = "";

            // pelatihan_id
            $this->pelatihan_id->LinkCustomAttributes = "";
            $this->pelatihan_id->HrefValue = "";
            $this->pelatihan_id->TooltipValue = "";

            // Biaya
            $this->Biaya->LinkCustomAttributes = "";
            $this->Biaya->HrefValue = "";
            $this->Biaya->TooltipValue = "";

            // tgl_tranfer
            $this->tgl_tranfer->LinkCustomAttributes = "";
            $this->tgl_tranfer->HrefValue = "";
            $this->tgl_tranfer->TooltipValue = "";

            // bukti_pembayaran
            $this->bukti_pembayaran->LinkCustomAttributes = "";
            $this->bukti_pembayaran->UploadPath = "files/bukti_pembayaran/";
            if (!EmptyValue($this->bukti_pembayaran->Upload->DbValue)) {
                $this->bukti_pembayaran->HrefValue = GetFileUploadUrl($this->bukti_pembayaran, $this->bukti_pembayaran->htmlDecode($this->bukti_pembayaran->Upload->DbValue)); // Add prefix/suffix
                $this->bukti_pembayaran->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->bukti_pembayaran->HrefValue = FullUrl($this->bukti_pembayaran->HrefValue, "href");
                }
            } else {
                $this->bukti_pembayaran->HrefValue = "";
            }
            $this->bukti_pembayaran->ExportHrefValue = $this->bukti_pembayaran->UploadPath . $this->bukti_pembayaran->Upload->DbValue;
            $this->bukti_pembayaran->TooltipValue = "";
            if ($this->bukti_pembayaran->UseColorbox) {
                if (EmptyValue($this->bukti_pembayaran->TooltipValue)) {
                    $this->bukti_pembayaran->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->bukti_pembayaran->LinkAttrs["data-rel"] = "w_orders_x" . $this->RowCount . "_bukti_pembayaran";
                $this->bukti_pembayaran->LinkAttrs->appendClass("ew-lightbox");
            }

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
            // nama_peserta
            $this->nama_peserta->EditAttrs["class"] = "form-control";
            $this->nama_peserta->EditCustomAttributes = "";
            if (!$this->nama_peserta->Raw) {
                $this->nama_peserta->AdvancedSearch->SearchValue = HtmlDecode($this->nama_peserta->AdvancedSearch->SearchValue);
            }
            $this->nama_peserta->EditValue = HtmlEncode($this->nama_peserta->AdvancedSearch->SearchValue);
            $this->nama_peserta->PlaceHolder = RemoveHtml($this->nama_peserta->caption());

            // username
            $this->_username->EditAttrs["class"] = "form-control";
            $this->_username->EditCustomAttributes = "";
            $this->_username->PlaceHolder = RemoveHtml($this->_username->caption());

            // nama_perusahaan
            $this->nama_perusahaan->EditAttrs["class"] = "form-control";
            $this->nama_perusahaan->EditCustomAttributes = "";
            if (!$this->nama_perusahaan->Raw) {
                $this->nama_perusahaan->AdvancedSearch->SearchValue = HtmlDecode($this->nama_perusahaan->AdvancedSearch->SearchValue);
            }
            $this->nama_perusahaan->EditValue = HtmlEncode($this->nama_perusahaan->AdvancedSearch->SearchValue);
            $this->nama_perusahaan->PlaceHolder = RemoveHtml($this->nama_perusahaan->caption());

            // pelatihan_id
            $this->pelatihan_id->EditAttrs["class"] = "form-control";
            $this->pelatihan_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->pelatihan_id->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->pelatihan_id->AdvancedSearch->ViewValue = $this->pelatihan_id->lookupCacheOption($curVal);
            } else {
                $this->pelatihan_id->AdvancedSearch->ViewValue = $this->pelatihan_id->Lookup !== null && is_array($this->pelatihan_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->pelatihan_id->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->pelatihan_id->EditValue = array_values($this->pelatihan_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`pelatihan_id`" . SearchString("=", $this->pelatihan_id->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return "`Activated` = 'Y'";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->pelatihan_id->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->pelatihan_id->EditValue = $arwrk;
            }
            $this->pelatihan_id->PlaceHolder = RemoveHtml($this->pelatihan_id->caption());

            // Biaya
            $this->Biaya->EditAttrs["class"] = "form-control";
            $this->Biaya->EditCustomAttributes = "";
            $this->Biaya->EditValue = HtmlEncode($this->Biaya->AdvancedSearch->SearchValue);
            $this->Biaya->PlaceHolder = RemoveHtml($this->Biaya->caption());

            // tgl_tranfer
            $this->tgl_tranfer->EditAttrs["class"] = "form-control";
            $this->tgl_tranfer->EditCustomAttributes = "";
            $this->tgl_tranfer->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->tgl_tranfer->AdvancedSearch->SearchValue, 0), 8));
            $this->tgl_tranfer->PlaceHolder = RemoveHtml($this->tgl_tranfer->caption());

            // bukti_pembayaran
            $this->bukti_pembayaran->EditAttrs["class"] = "form-control";
            $this->bukti_pembayaran->EditCustomAttributes = "style='width:300px;'";
            if (!$this->bukti_pembayaran->Raw) {
                $this->bukti_pembayaran->AdvancedSearch->SearchValue = HtmlDecode($this->bukti_pembayaran->AdvancedSearch->SearchValue);
            }
            $this->bukti_pembayaran->EditValue = HtmlEncode($this->bukti_pembayaran->AdvancedSearch->SearchValue);
            $this->bukti_pembayaran->PlaceHolder = RemoveHtml($this->bukti_pembayaran->caption());

            // status
            $this->status->EditAttrs["class"] = "form-control";
            $this->status->EditCustomAttributes = "";
            $this->status->EditValue = $this->status->options(true);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate search
    protected function validateSearch()
    {
        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }

        // Return validate result
        $validateSearch = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateSearch = $validateSearch && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateSearch;
    }

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->order_id->AdvancedSearch->load();
        $this->nama_peserta->AdvancedSearch->load();
        $this->_username->AdvancedSearch->load();
        $this->nama_perusahaan->AdvancedSearch->load();
        $this->pelatihan_id->AdvancedSearch->load();
        $this->Biaya->AdvancedSearch->load();
        $this->tgl_tranfer->AdvancedSearch->load();
        $this->bukti_pembayaran->AdvancedSearch->load();
        $this->created_at->AdvancedSearch->load();
        $this->updated_at->AdvancedSearch->load();
        $this->status->AdvancedSearch->load();
    }

    // Set up search options
    protected function setupSearchOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl();
        $this->SearchOptions = new ListOptions("div");
        $this->SearchOptions->TagClassName = "ew-search-option";

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fw_orderslistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        $item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->add($this->SearchOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction) {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$Security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
        $Breadcrumb->add("list", $this->TableVar, $url, "", $this->TableVar, true);
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
                case "x__username":
                    break;
                case "x_pelatihan_id":
                    $lookupFilter = function () {
                        return "`Activated` = 'Y'";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_status":
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
        $this->_username->Visible = FALSE;
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

    // ListOptions Load event
    public function listOptionsLoad()
    {
    	$opt = &$this->ListOptions->Add("new");
    	$opt->Header = "Aksi";
    	$opt->OnLeft = false; // Link on left
    	$opt->MoveTo(0); // Move to first column
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    // ListOptions Rendered event
    public function listOptionsRendered()
    {
    	$this->ListOptions["new"]->Body = "";
    	if ($this->status->CurrentValue <> 3 && CurrentUserLevel() <> 2  ) { //diterima
    	$this->ListOptions->Items["new"]->Body .= "<a href=\"#\" onclick=\"return ew.submitAction(event, {action: 'diterima', method: 'post', msg: 'Apakah Anda yakin <b>menerima pembayaran</b> ini?', key: " . $this->keyToJson(true) . "});\" class=\"btn btn-success w-100\"><i class=\"fas fa-check ew-icon\"></i> Pembayaran diterima</a><br><br>";
    	}
    	if (($this->status->CurrentValue <> 10 && $this->status->CurrentValue <> 2) && (CurrentUserLevel() == -1 || CurrentUserLevel() == 2 )) { //booking
    	$this->ListOptions->Items["new"]->Body .= "<a href=\"#\" onclick=\"return ew.submitAction(event, {action: 'booking', method: 'post', msg: 'Apakah Anda yakin <b>menjaga pesanan</b> ini?', key: " . $this->keyToJson(true) . "});\" class=\"btn btn-warning w-100\"><i class=\"fas fa-book ew-icon\"></i>  Booking</a><br><br>";	
    	}
    	if ($this->status->CurrentValue <> 0 && CurrentUserLevel() <> 2 ) { //batal
    	$this->ListOptions->Items["new"]->Body .= "<a href=\"#\" onclick=\"return ew.submitAction(event, {action: 'ditolak', method: 'post', msg: 'Apakah Anda yakin </b>membatalkan pesanan<b> ini?', key: " . $this->keyToJson(true) . "});\" class=\"btn btn-danger w-100\"><i class=\"fas fa-ban ew-icon\"></i>  Batalkan</a>";
    	}
    }

    // Row Custom Action event
    public function rowCustomAction($action, $row)
    {
        // Return false to abort
    	if ($action == "diterima") {
    		$rsnew = ["status" => 3,]; 
    		$result = $this->update($rsnew, "order_id = " . $row["order_id"]);
    		if (!$result) { // Failure
    				$this->setFailureMessage("Failed ID = " . $row["order_id"]);
    				return false; // Abort and rollback
    		} elseif ($this->SelectedIndex == $this->SelectedCount) { // Last row
    				$this->setSuccessMessage("Perubahan status berhasil.");                
    		}
    	} else 	if ($action == "ditolak") {
    		$rsnew = ["status" => 0,]; 
    		$result = $this->update($rsnew, "order_id = " . $row["order_id"]);
    		if (!$result) { // Failure
    				$this->setFailureMessage("Failed ID = " . $row["order_id"]);
    				return false; // Abort and rollback
    		} elseif ($this->SelectedIndex == $this->SelectedCount) { // Last row
    				$this->setSuccessMessage("Pembayaran dibatalkan.");                
    		}
    	} else 	if ($action == "booking") {
    		$rsnew = ["status" => 10,]; 
    		$result = $this->update($rsnew, "order_id = " . $row["order_id"]);
    		if (!$result) { // Failure
    				$this->setFailureMessage("Failed ID = " . $row["order_id"]);
    				return false; // Abort and rollback
    		} elseif ($this->SelectedIndex == $this->SelectedCount) { // Last row
    				$this->setSuccessMessage("Pesanan telah disetujui.");                
    		}
    	}
        return true;
    }

    // Page Exporting event
    // $this->ExportDoc = export document object
    public function pageExporting()
    {
        //$this->ExportDoc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $this->ExportDoc = export document object
    public function rowExport($rs)
    {
        //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $this->ExportDoc = export document object
    public function pageExported()
    {
        //$this->ExportDoc->Text .= "my footer"; // Export footer
        //Log($this->ExportDoc->Text);
    }

    // Page Importing event
    public function pageImporting($reader, &$options)
    {
        //var_dump($reader); // Import data reader
        //var_dump($options); // Show all options for importing
        //return false; // Return false to skip import
        return true;
    }

    // Row Import event
    public function rowImport(&$row, $cnt)
    {
        //Log($cnt); // Import record count
        //var_dump($row); // Import row
        //return false; // Return false to skip import
        return true;
    }

    // Page Imported event
    public function pageImported($reader, $results)
    {
        //var_dump($reader); // Import data reader
        //var_dump($results); // Import results
    }
}
