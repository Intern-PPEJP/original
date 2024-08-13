<?php

namespace PHPMaker2021\ppejp_web;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class WPelatihanList extends WPelatihan
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'w_pelatihan';

    // Page object name
    public $PageObjName = "WPelatihanList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fw_pelatihanlist";
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

        // Table object (w_pelatihan)
        if (!isset($GLOBALS["w_pelatihan"]) || get_class($GLOBALS["w_pelatihan"]) == PROJECT_NAMESPACE . "w_pelatihan") {
            $GLOBALS["w_pelatihan"] = &$this;
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
        $this->AddUrl = "wpelatihanadd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "wpelatihandelete";
        $this->MultiUpdateUrl = "wpelatihanupdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'w_pelatihan');
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
        $this->FilterOptions->TagClassName = "ew-filter-option fw_pelatihanlistsrch";

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
                $doc = new $class(Container("w_pelatihan"));
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
            $key .= @$ar['pelatihan_id'];
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
            $this->pelatihan_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->Last_Updated->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->Created_Date->Visible = false;
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
        $this->pelatihan_id->setVisibility();
        $this->jenis_pelatihan->setVisibility();
        $this->judul_pelatihan->setVisibility();
        $this->jumlah_hari->setVisibility();
        $this->tempat->setVisibility();
        $this->jumlah_peserta->setVisibility();
        $this->sisa->setVisibility();
        $this->harga->setVisibility();
        $this->tawal->Visible = false;
        $this->takhir->Visible = false;
        $this->tanggal_pelaksanaan->setVisibility();
        $this->gambar->setVisibility();
        $this->kategori->setVisibility();
        $this->tujuan->Visible = false;
        $this->sub_kategori->Visible = false;
        $this->topik_bahasan->Visible = false;
        $this->catatan->Visible = false;
        $this->Link->Visible = false;
        $this->Last_Updated->Visible = false;
        $this->Created_Date->Visible = false;
        $this->Activated->setVisibility();
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
            AddFilter($this->DefaultSearchWhere, $this->basicSearchWhere(true));
            AddFilter($this->DefaultSearchWhere, $this->advancedSearchWhere(true));

            // Get basic search values
            $this->loadBasicSearchValues();

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

            // Get basic search criteria
            if (!$this->hasInvalidFields()) {
                $srchBasic = $this->basicSearchWhere();
            }

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
            // Load basic search from default
            $this->BasicSearch->loadDefault();
            if ($this->BasicSearch->Keyword != "") {
                $srchBasic = $this->basicSearchWhere();
            }

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
        $filterList = Concat($filterList, $this->pelatihan_id->AdvancedSearch->toJson(), ","); // Field pelatihan_id
        $filterList = Concat($filterList, $this->jenis_pelatihan->AdvancedSearch->toJson(), ","); // Field jenis_pelatihan
        $filterList = Concat($filterList, $this->judul_pelatihan->AdvancedSearch->toJson(), ","); // Field judul_pelatihan
        $filterList = Concat($filterList, $this->jumlah_hari->AdvancedSearch->toJson(), ","); // Field jumlah_hari
        $filterList = Concat($filterList, $this->tempat->AdvancedSearch->toJson(), ","); // Field tempat
        $filterList = Concat($filterList, $this->jumlah_peserta->AdvancedSearch->toJson(), ","); // Field jumlah_peserta
        $filterList = Concat($filterList, $this->sisa->AdvancedSearch->toJson(), ","); // Field sisa
        $filterList = Concat($filterList, $this->harga->AdvancedSearch->toJson(), ","); // Field harga
        $filterList = Concat($filterList, $this->tawal->AdvancedSearch->toJson(), ","); // Field tawal
        $filterList = Concat($filterList, $this->takhir->AdvancedSearch->toJson(), ","); // Field takhir
        $filterList = Concat($filterList, $this->tanggal_pelaksanaan->AdvancedSearch->toJson(), ","); // Field tanggal_pelaksanaan
        $filterList = Concat($filterList, $this->gambar->AdvancedSearch->toJson(), ","); // Field gambar
        $filterList = Concat($filterList, $this->kategori->AdvancedSearch->toJson(), ","); // Field kategori
        $filterList = Concat($filterList, $this->tujuan->AdvancedSearch->toJson(), ","); // Field tujuan
        $filterList = Concat($filterList, $this->sub_kategori->AdvancedSearch->toJson(), ","); // Field sub_kategori
        $filterList = Concat($filterList, $this->topik_bahasan->AdvancedSearch->toJson(), ","); // Field topik_bahasan
        $filterList = Concat($filterList, $this->catatan->AdvancedSearch->toJson(), ","); // Field catatan
        $filterList = Concat($filterList, $this->Link->AdvancedSearch->toJson(), ","); // Field Link
        $filterList = Concat($filterList, $this->Last_Updated->AdvancedSearch->toJson(), ","); // Field Last_Updated
        $filterList = Concat($filterList, $this->Created_Date->AdvancedSearch->toJson(), ","); // Field Created_Date
        $filterList = Concat($filterList, $this->Activated->AdvancedSearch->toJson(), ","); // Field Activated
        if ($this->BasicSearch->Keyword != "") {
            $wrk = "\"" . Config("TABLE_BASIC_SEARCH") . "\":\"" . JsEncode($this->BasicSearch->Keyword) . "\",\"" . Config("TABLE_BASIC_SEARCH_TYPE") . "\":\"" . JsEncode($this->BasicSearch->Type) . "\"";
            $filterList = Concat($filterList, $wrk, ",");
        }

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
            $UserProfile->setSearchFilters(CurrentUserName(), "fw_pelatihanlistsrch", $filters);
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

        // Field pelatihan_id
        $this->pelatihan_id->AdvancedSearch->SearchValue = @$filter["x_pelatihan_id"];
        $this->pelatihan_id->AdvancedSearch->SearchOperator = @$filter["z_pelatihan_id"];
        $this->pelatihan_id->AdvancedSearch->SearchCondition = @$filter["v_pelatihan_id"];
        $this->pelatihan_id->AdvancedSearch->SearchValue2 = @$filter["y_pelatihan_id"];
        $this->pelatihan_id->AdvancedSearch->SearchOperator2 = @$filter["w_pelatihan_id"];
        $this->pelatihan_id->AdvancedSearch->save();

        // Field jenis_pelatihan
        $this->jenis_pelatihan->AdvancedSearch->SearchValue = @$filter["x_jenis_pelatihan"];
        $this->jenis_pelatihan->AdvancedSearch->SearchOperator = @$filter["z_jenis_pelatihan"];
        $this->jenis_pelatihan->AdvancedSearch->SearchCondition = @$filter["v_jenis_pelatihan"];
        $this->jenis_pelatihan->AdvancedSearch->SearchValue2 = @$filter["y_jenis_pelatihan"];
        $this->jenis_pelatihan->AdvancedSearch->SearchOperator2 = @$filter["w_jenis_pelatihan"];
        $this->jenis_pelatihan->AdvancedSearch->save();

        // Field judul_pelatihan
        $this->judul_pelatihan->AdvancedSearch->SearchValue = @$filter["x_judul_pelatihan"];
        $this->judul_pelatihan->AdvancedSearch->SearchOperator = @$filter["z_judul_pelatihan"];
        $this->judul_pelatihan->AdvancedSearch->SearchCondition = @$filter["v_judul_pelatihan"];
        $this->judul_pelatihan->AdvancedSearch->SearchValue2 = @$filter["y_judul_pelatihan"];
        $this->judul_pelatihan->AdvancedSearch->SearchOperator2 = @$filter["w_judul_pelatihan"];
        $this->judul_pelatihan->AdvancedSearch->save();

        // Field jumlah_hari
        $this->jumlah_hari->AdvancedSearch->SearchValue = @$filter["x_jumlah_hari"];
        $this->jumlah_hari->AdvancedSearch->SearchOperator = @$filter["z_jumlah_hari"];
        $this->jumlah_hari->AdvancedSearch->SearchCondition = @$filter["v_jumlah_hari"];
        $this->jumlah_hari->AdvancedSearch->SearchValue2 = @$filter["y_jumlah_hari"];
        $this->jumlah_hari->AdvancedSearch->SearchOperator2 = @$filter["w_jumlah_hari"];
        $this->jumlah_hari->AdvancedSearch->save();

        // Field tempat
        $this->tempat->AdvancedSearch->SearchValue = @$filter["x_tempat"];
        $this->tempat->AdvancedSearch->SearchOperator = @$filter["z_tempat"];
        $this->tempat->AdvancedSearch->SearchCondition = @$filter["v_tempat"];
        $this->tempat->AdvancedSearch->SearchValue2 = @$filter["y_tempat"];
        $this->tempat->AdvancedSearch->SearchOperator2 = @$filter["w_tempat"];
        $this->tempat->AdvancedSearch->save();

        // Field jumlah_peserta
        $this->jumlah_peserta->AdvancedSearch->SearchValue = @$filter["x_jumlah_peserta"];
        $this->jumlah_peserta->AdvancedSearch->SearchOperator = @$filter["z_jumlah_peserta"];
        $this->jumlah_peserta->AdvancedSearch->SearchCondition = @$filter["v_jumlah_peserta"];
        $this->jumlah_peserta->AdvancedSearch->SearchValue2 = @$filter["y_jumlah_peserta"];
        $this->jumlah_peserta->AdvancedSearch->SearchOperator2 = @$filter["w_jumlah_peserta"];
        $this->jumlah_peserta->AdvancedSearch->save();

        // Field sisa
        $this->sisa->AdvancedSearch->SearchValue = @$filter["x_sisa"];
        $this->sisa->AdvancedSearch->SearchOperator = @$filter["z_sisa"];
        $this->sisa->AdvancedSearch->SearchCondition = @$filter["v_sisa"];
        $this->sisa->AdvancedSearch->SearchValue2 = @$filter["y_sisa"];
        $this->sisa->AdvancedSearch->SearchOperator2 = @$filter["w_sisa"];
        $this->sisa->AdvancedSearch->save();

        // Field harga
        $this->harga->AdvancedSearch->SearchValue = @$filter["x_harga"];
        $this->harga->AdvancedSearch->SearchOperator = @$filter["z_harga"];
        $this->harga->AdvancedSearch->SearchCondition = @$filter["v_harga"];
        $this->harga->AdvancedSearch->SearchValue2 = @$filter["y_harga"];
        $this->harga->AdvancedSearch->SearchOperator2 = @$filter["w_harga"];
        $this->harga->AdvancedSearch->save();

        // Field tawal
        $this->tawal->AdvancedSearch->SearchValue = @$filter["x_tawal"];
        $this->tawal->AdvancedSearch->SearchOperator = @$filter["z_tawal"];
        $this->tawal->AdvancedSearch->SearchCondition = @$filter["v_tawal"];
        $this->tawal->AdvancedSearch->SearchValue2 = @$filter["y_tawal"];
        $this->tawal->AdvancedSearch->SearchOperator2 = @$filter["w_tawal"];
        $this->tawal->AdvancedSearch->save();

        // Field takhir
        $this->takhir->AdvancedSearch->SearchValue = @$filter["x_takhir"];
        $this->takhir->AdvancedSearch->SearchOperator = @$filter["z_takhir"];
        $this->takhir->AdvancedSearch->SearchCondition = @$filter["v_takhir"];
        $this->takhir->AdvancedSearch->SearchValue2 = @$filter["y_takhir"];
        $this->takhir->AdvancedSearch->SearchOperator2 = @$filter["w_takhir"];
        $this->takhir->AdvancedSearch->save();

        // Field tanggal_pelaksanaan
        $this->tanggal_pelaksanaan->AdvancedSearch->SearchValue = @$filter["x_tanggal_pelaksanaan"];
        $this->tanggal_pelaksanaan->AdvancedSearch->SearchOperator = @$filter["z_tanggal_pelaksanaan"];
        $this->tanggal_pelaksanaan->AdvancedSearch->SearchCondition = @$filter["v_tanggal_pelaksanaan"];
        $this->tanggal_pelaksanaan->AdvancedSearch->SearchValue2 = @$filter["y_tanggal_pelaksanaan"];
        $this->tanggal_pelaksanaan->AdvancedSearch->SearchOperator2 = @$filter["w_tanggal_pelaksanaan"];
        $this->tanggal_pelaksanaan->AdvancedSearch->save();

        // Field gambar
        $this->gambar->AdvancedSearch->SearchValue = @$filter["x_gambar"];
        $this->gambar->AdvancedSearch->SearchOperator = @$filter["z_gambar"];
        $this->gambar->AdvancedSearch->SearchCondition = @$filter["v_gambar"];
        $this->gambar->AdvancedSearch->SearchValue2 = @$filter["y_gambar"];
        $this->gambar->AdvancedSearch->SearchOperator2 = @$filter["w_gambar"];
        $this->gambar->AdvancedSearch->save();

        // Field kategori
        $this->kategori->AdvancedSearch->SearchValue = @$filter["x_kategori"];
        $this->kategori->AdvancedSearch->SearchOperator = @$filter["z_kategori"];
        $this->kategori->AdvancedSearch->SearchCondition = @$filter["v_kategori"];
        $this->kategori->AdvancedSearch->SearchValue2 = @$filter["y_kategori"];
        $this->kategori->AdvancedSearch->SearchOperator2 = @$filter["w_kategori"];
        $this->kategori->AdvancedSearch->save();

        // Field tujuan
        $this->tujuan->AdvancedSearch->SearchValue = @$filter["x_tujuan"];
        $this->tujuan->AdvancedSearch->SearchOperator = @$filter["z_tujuan"];
        $this->tujuan->AdvancedSearch->SearchCondition = @$filter["v_tujuan"];
        $this->tujuan->AdvancedSearch->SearchValue2 = @$filter["y_tujuan"];
        $this->tujuan->AdvancedSearch->SearchOperator2 = @$filter["w_tujuan"];
        $this->tujuan->AdvancedSearch->save();

        // Field sub_kategori
        $this->sub_kategori->AdvancedSearch->SearchValue = @$filter["x_sub_kategori"];
        $this->sub_kategori->AdvancedSearch->SearchOperator = @$filter["z_sub_kategori"];
        $this->sub_kategori->AdvancedSearch->SearchCondition = @$filter["v_sub_kategori"];
        $this->sub_kategori->AdvancedSearch->SearchValue2 = @$filter["y_sub_kategori"];
        $this->sub_kategori->AdvancedSearch->SearchOperator2 = @$filter["w_sub_kategori"];
        $this->sub_kategori->AdvancedSearch->save();

        // Field topik_bahasan
        $this->topik_bahasan->AdvancedSearch->SearchValue = @$filter["x_topik_bahasan"];
        $this->topik_bahasan->AdvancedSearch->SearchOperator = @$filter["z_topik_bahasan"];
        $this->topik_bahasan->AdvancedSearch->SearchCondition = @$filter["v_topik_bahasan"];
        $this->topik_bahasan->AdvancedSearch->SearchValue2 = @$filter["y_topik_bahasan"];
        $this->topik_bahasan->AdvancedSearch->SearchOperator2 = @$filter["w_topik_bahasan"];
        $this->topik_bahasan->AdvancedSearch->save();

        // Field catatan
        $this->catatan->AdvancedSearch->SearchValue = @$filter["x_catatan"];
        $this->catatan->AdvancedSearch->SearchOperator = @$filter["z_catatan"];
        $this->catatan->AdvancedSearch->SearchCondition = @$filter["v_catatan"];
        $this->catatan->AdvancedSearch->SearchValue2 = @$filter["y_catatan"];
        $this->catatan->AdvancedSearch->SearchOperator2 = @$filter["w_catatan"];
        $this->catatan->AdvancedSearch->save();

        // Field Link
        $this->Link->AdvancedSearch->SearchValue = @$filter["x_Link"];
        $this->Link->AdvancedSearch->SearchOperator = @$filter["z_Link"];
        $this->Link->AdvancedSearch->SearchCondition = @$filter["v_Link"];
        $this->Link->AdvancedSearch->SearchValue2 = @$filter["y_Link"];
        $this->Link->AdvancedSearch->SearchOperator2 = @$filter["w_Link"];
        $this->Link->AdvancedSearch->save();

        // Field Last_Updated
        $this->Last_Updated->AdvancedSearch->SearchValue = @$filter["x_Last_Updated"];
        $this->Last_Updated->AdvancedSearch->SearchOperator = @$filter["z_Last_Updated"];
        $this->Last_Updated->AdvancedSearch->SearchCondition = @$filter["v_Last_Updated"];
        $this->Last_Updated->AdvancedSearch->SearchValue2 = @$filter["y_Last_Updated"];
        $this->Last_Updated->AdvancedSearch->SearchOperator2 = @$filter["w_Last_Updated"];
        $this->Last_Updated->AdvancedSearch->save();

        // Field Created_Date
        $this->Created_Date->AdvancedSearch->SearchValue = @$filter["x_Created_Date"];
        $this->Created_Date->AdvancedSearch->SearchOperator = @$filter["z_Created_Date"];
        $this->Created_Date->AdvancedSearch->SearchCondition = @$filter["v_Created_Date"];
        $this->Created_Date->AdvancedSearch->SearchValue2 = @$filter["y_Created_Date"];
        $this->Created_Date->AdvancedSearch->SearchOperator2 = @$filter["w_Created_Date"];
        $this->Created_Date->AdvancedSearch->save();

        // Field Activated
        $this->Activated->AdvancedSearch->SearchValue = @$filter["x_Activated"];
        $this->Activated->AdvancedSearch->SearchOperator = @$filter["z_Activated"];
        $this->Activated->AdvancedSearch->SearchCondition = @$filter["v_Activated"];
        $this->Activated->AdvancedSearch->SearchValue2 = @$filter["y_Activated"];
        $this->Activated->AdvancedSearch->SearchOperator2 = @$filter["w_Activated"];
        $this->Activated->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Advanced search WHERE clause based on QueryString
    protected function advancedSearchWhere($default = false)
    {
        global $Security;
        $where = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $this->buildSearchSql($where, $this->pelatihan_id, $default, false); // pelatihan_id
        $this->buildSearchSql($where, $this->jenis_pelatihan, $default, false); // jenis_pelatihan
        $this->buildSearchSql($where, $this->judul_pelatihan, $default, false); // judul_pelatihan
        $this->buildSearchSql($where, $this->jumlah_hari, $default, false); // jumlah_hari
        $this->buildSearchSql($where, $this->tempat, $default, false); // tempat
        $this->buildSearchSql($where, $this->jumlah_peserta, $default, false); // jumlah_peserta
        $this->buildSearchSql($where, $this->sisa, $default, false); // sisa
        $this->buildSearchSql($where, $this->harga, $default, false); // harga
        $this->buildSearchSql($where, $this->tawal, $default, false); // tawal
        $this->buildSearchSql($where, $this->takhir, $default, false); // takhir
        $this->buildSearchSql($where, $this->tanggal_pelaksanaan, $default, false); // tanggal_pelaksanaan
        $this->buildSearchSql($where, $this->gambar, $default, false); // gambar
        $this->buildSearchSql($where, $this->kategori, $default, false); // kategori
        $this->buildSearchSql($where, $this->tujuan, $default, false); // tujuan
        $this->buildSearchSql($where, $this->sub_kategori, $default, false); // sub_kategori
        $this->buildSearchSql($where, $this->topik_bahasan, $default, false); // topik_bahasan
        $this->buildSearchSql($where, $this->catatan, $default, false); // catatan
        $this->buildSearchSql($where, $this->Link, $default, false); // Link
        $this->buildSearchSql($where, $this->Last_Updated, $default, false); // Last_Updated
        $this->buildSearchSql($where, $this->Created_Date, $default, false); // Created_Date
        $this->buildSearchSql($where, $this->Activated, $default, false); // Activated

        // Set up search parm
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->pelatihan_id->AdvancedSearch->save(); // pelatihan_id
            $this->jenis_pelatihan->AdvancedSearch->save(); // jenis_pelatihan
            $this->judul_pelatihan->AdvancedSearch->save(); // judul_pelatihan
            $this->jumlah_hari->AdvancedSearch->save(); // jumlah_hari
            $this->tempat->AdvancedSearch->save(); // tempat
            $this->jumlah_peserta->AdvancedSearch->save(); // jumlah_peserta
            $this->sisa->AdvancedSearch->save(); // sisa
            $this->harga->AdvancedSearch->save(); // harga
            $this->tawal->AdvancedSearch->save(); // tawal
            $this->takhir->AdvancedSearch->save(); // takhir
            $this->tanggal_pelaksanaan->AdvancedSearch->save(); // tanggal_pelaksanaan
            $this->gambar->AdvancedSearch->save(); // gambar
            $this->kategori->AdvancedSearch->save(); // kategori
            $this->tujuan->AdvancedSearch->save(); // tujuan
            $this->sub_kategori->AdvancedSearch->save(); // sub_kategori
            $this->topik_bahasan->AdvancedSearch->save(); // topik_bahasan
            $this->catatan->AdvancedSearch->save(); // catatan
            $this->Link->AdvancedSearch->save(); // Link
            $this->Last_Updated->AdvancedSearch->save(); // Last_Updated
            $this->Created_Date->AdvancedSearch->save(); // Created_Date
            $this->Activated->AdvancedSearch->save(); // Activated
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

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->jenis_pelatihan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->judul_pelatihan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->jumlah_hari, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->tempat, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->harga, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->tanggal_pelaksanaan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kategori, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->tujuan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->sub_kategori, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->topik_bahasan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->catatan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->Link, $arKeywords, $type);
        return $where;
    }

    // Build basic search SQL
    protected function buildBasicSearchSql(&$where, &$fld, $arKeywords, $type)
    {
        $defCond = ($type == "OR") ? "OR" : "AND";
        $arSql = []; // Array for SQL parts
        $arCond = []; // Array for search conditions
        $cnt = count($arKeywords);
        $j = 0; // Number of SQL parts
        for ($i = 0; $i < $cnt; $i++) {
            $keyword = $arKeywords[$i];
            $keyword = trim($keyword);
            if (Config("BASIC_SEARCH_IGNORE_PATTERN") != "") {
                $keyword = preg_replace(Config("BASIC_SEARCH_IGNORE_PATTERN"), "\\", $keyword);
                $ar = explode("\\", $keyword);
            } else {
                $ar = [$keyword];
            }
            foreach ($ar as $keyword) {
                if ($keyword != "") {
                    $wrk = "";
                    if ($keyword == "OR" && $type == "") {
                        if ($j > 0) {
                            $arCond[$j - 1] = "OR";
                        }
                    } elseif ($keyword == Config("NULL_VALUE")) {
                        $wrk = $fld->Expression . " IS NULL";
                    } elseif ($keyword == Config("NOT_NULL_VALUE")) {
                        $wrk = $fld->Expression . " IS NOT NULL";
                    } elseif ($fld->IsVirtual && $fld->Visible) {
                        $wrk = $fld->VirtualExpression . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Dbid), $this->Dbid);
                    } elseif ($fld->DataType != DATATYPE_NUMBER || is_numeric($keyword)) {
                        $wrk = $fld->BasicSearchExpression . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Dbid), $this->Dbid);
                    }
                    if ($wrk != "") {
                        $arSql[$j] = $wrk;
                        $arCond[$j] = $defCond;
                        $j += 1;
                    }
                }
            }
        }
        $cnt = count($arSql);
        $quoted = false;
        $sql = "";
        if ($cnt > 0) {
            for ($i = 0; $i < $cnt - 1; $i++) {
                if ($arCond[$i] == "OR") {
                    if (!$quoted) {
                        $sql .= "(";
                    }
                    $quoted = true;
                }
                $sql .= $arSql[$i];
                if ($quoted && $arCond[$i] != "OR") {
                    $sql .= ")";
                    $quoted = false;
                }
                $sql .= " " . $arCond[$i] . " ";
            }
            $sql .= $arSql[$cnt - 1];
            if ($quoted) {
                $sql .= ")";
            }
        }
        if ($sql != "") {
            if ($where != "") {
                $where .= " OR ";
            }
            $where .= "(" . $sql . ")";
        }
    }

    // Return basic search WHERE clause based on search keyword and type
    protected function basicSearchWhere($default = false)
    {
        global $Security;
        $searchStr = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $searchKeyword = ($default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
        $searchType = ($default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

        // Get search SQL
        if ($searchKeyword != "") {
            $ar = $this->BasicSearch->keywordList($default);
            // Search keyword in any fields
            if (($searchType == "OR" || $searchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
                foreach ($ar as $keyword) {
                    if ($keyword != "") {
                        if ($searchStr != "") {
                            $searchStr .= " " . $searchType . " ";
                        }
                        $searchStr .= "(" . $this->basicSearchSql([$keyword], $searchType) . ")";
                    }
                }
            } else {
                $searchStr = $this->basicSearchSql($ar, $searchType);
            }
            if (!$default && in_array($this->Command, ["", "reset", "resetall"])) {
                $this->Command = "search";
            }
        }
        if (!$default && $this->Command == "search") {
            $this->BasicSearch->setKeyword($searchKeyword);
            $this->BasicSearch->setType($searchType);
        }
        return $searchStr;
    }

    // Check if search parm exists
    protected function checkSearchParms()
    {
        // Check basic search
        if ($this->BasicSearch->issetSession()) {
            return true;
        }
        if ($this->pelatihan_id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->jenis_pelatihan->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->judul_pelatihan->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->jumlah_hari->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->tempat->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->jumlah_peserta->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->sisa->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->harga->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->tawal->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->takhir->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->tanggal_pelaksanaan->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->gambar->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->kategori->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->tujuan->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->sub_kategori->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->topik_bahasan->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->catatan->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->Link->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->Last_Updated->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->Created_Date->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->Activated->AdvancedSearch->issetSession()) {
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

        // Clear basic search parameters
        $this->resetBasicSearchParms();

        // Clear advanced search parameters
        $this->resetAdvancedSearchParms();
    }

    // Load advanced search default values
    protected function loadAdvancedSearchDefault()
    {
        return false;
    }

    // Clear all basic search parameters
    protected function resetBasicSearchParms()
    {
        $this->BasicSearch->unsetSession();
    }

    // Clear all advanced search parameters
    protected function resetAdvancedSearchParms()
    {
                $this->pelatihan_id->AdvancedSearch->unsetSession();
                $this->jenis_pelatihan->AdvancedSearch->unsetSession();
                $this->judul_pelatihan->AdvancedSearch->unsetSession();
                $this->jumlah_hari->AdvancedSearch->unsetSession();
                $this->tempat->AdvancedSearch->unsetSession();
                $this->jumlah_peserta->AdvancedSearch->unsetSession();
                $this->sisa->AdvancedSearch->unsetSession();
                $this->harga->AdvancedSearch->unsetSession();
                $this->tawal->AdvancedSearch->unsetSession();
                $this->takhir->AdvancedSearch->unsetSession();
                $this->tanggal_pelaksanaan->AdvancedSearch->unsetSession();
                $this->gambar->AdvancedSearch->unsetSession();
                $this->kategori->AdvancedSearch->unsetSession();
                $this->tujuan->AdvancedSearch->unsetSession();
                $this->sub_kategori->AdvancedSearch->unsetSession();
                $this->topik_bahasan->AdvancedSearch->unsetSession();
                $this->catatan->AdvancedSearch->unsetSession();
                $this->Link->AdvancedSearch->unsetSession();
                $this->Last_Updated->AdvancedSearch->unsetSession();
                $this->Created_Date->AdvancedSearch->unsetSession();
                $this->Activated->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
                $this->pelatihan_id->AdvancedSearch->load();
                $this->jenis_pelatihan->AdvancedSearch->load();
                $this->judul_pelatihan->AdvancedSearch->load();
                $this->jumlah_hari->AdvancedSearch->load();
                $this->tempat->AdvancedSearch->load();
                $this->jumlah_peserta->AdvancedSearch->load();
                $this->sisa->AdvancedSearch->load();
                $this->harga->AdvancedSearch->load();
                $this->tawal->AdvancedSearch->load();
                $this->takhir->AdvancedSearch->load();
                $this->tanggal_pelaksanaan->AdvancedSearch->load();
                $this->gambar->AdvancedSearch->load();
                $this->kategori->AdvancedSearch->load();
                $this->tujuan->AdvancedSearch->load();
                $this->sub_kategori->AdvancedSearch->load();
                $this->topik_bahasan->AdvancedSearch->load();
                $this->catatan->AdvancedSearch->load();
                $this->Link->AdvancedSearch->load();
                $this->Last_Updated->AdvancedSearch->load();
                $this->Created_Date->AdvancedSearch->load();
                $this->Activated->AdvancedSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->pelatihan_id); // pelatihan_id
            $this->updateSort($this->jenis_pelatihan); // jenis_pelatihan
            $this->updateSort($this->judul_pelatihan); // judul_pelatihan
            $this->updateSort($this->jumlah_hari); // jumlah_hari
            $this->updateSort($this->tempat); // tempat
            $this->updateSort($this->jumlah_peserta); // jumlah_peserta
            $this->updateSort($this->sisa); // sisa
            $this->updateSort($this->harga); // harga
            $this->updateSort($this->tanggal_pelaksanaan); // tanggal_pelaksanaan
            $this->updateSort($this->gambar); // gambar
            $this->updateSort($this->kategori); // kategori
            $this->updateSort($this->Activated); // Activated
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
                $this->pelatihan_id->setSort("");
                $this->jenis_pelatihan->setSort("");
                $this->judul_pelatihan->setSort("");
                $this->jumlah_hari->setSort("");
                $this->tempat->setSort("");
                $this->jumlah_peserta->setSort("");
                $this->sisa->setSort("");
                $this->harga->setSort("");
                $this->tawal->setSort("");
                $this->takhir->setSort("");
                $this->tanggal_pelaksanaan->setSort("");
                $this->gambar->setSort("");
                $this->kategori->setSort("");
                $this->tujuan->setSort("");
                $this->sub_kategori->setSort("");
                $this->topik_bahasan->setSort("");
                $this->catatan->setSort("");
                $this->Link->setSort("");
                $this->Last_Updated->setSort("");
                $this->Created_Date->setSort("");
                $this->Activated->setSort("");
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

        // "view"
        $item = &$this->ListOptions->add("view");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canView();
        $item->OnLeft = false;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canEdit();
        $item->OnLeft = false;

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canDelete();
        $item->OnLeft = false;

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

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = true;
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
        $pageUrl = $this->pageUrl();
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView()) {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "delete"
            $opt = $this->ListOptions["delete"];
            if ($Security->canDelete()) {
            $opt->Body = "<a class=\"ew-row-link ew-delete\"" . "" . " title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("DeleteLink") . "</a>";
            } else {
                $opt->Body = "";
            }
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
        $opt->Body = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"custom-control-input ew-multi-select\" value=\"" . HtmlEncode($this->pelatihan_id->CurrentValue) . "\" onclick=\"ew.clickMultiCheckbox(event);\"><label class=\"custom-control-label\" for=\"key_m_" . $this->RowCount . "\"></label></div>";
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fw_pelatihanlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fw_pelatihanlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fw_pelatihanlist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
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

    // Load basic search values
    protected function loadBasicSearchValues()
    {
        $this->BasicSearch->setKeyword(Get(Config("TABLE_BASIC_SEARCH"), ""), false);
        if ($this->BasicSearch->Keyword != "" && $this->Command == "") {
            $this->Command = "search";
        }
        $this->BasicSearch->setType(Get(Config("TABLE_BASIC_SEARCH_TYPE"), ""), false);
    }

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;

        // pelatihan_id
        if (!$this->isAddOrEdit() && $this->pelatihan_id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->pelatihan_id->AdvancedSearch->SearchValue != "" || $this->pelatihan_id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // jenis_pelatihan
        if (!$this->isAddOrEdit() && $this->jenis_pelatihan->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->jenis_pelatihan->AdvancedSearch->SearchValue != "" || $this->jenis_pelatihan->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // judul_pelatihan
        if (!$this->isAddOrEdit() && $this->judul_pelatihan->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->judul_pelatihan->AdvancedSearch->SearchValue != "" || $this->judul_pelatihan->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // jumlah_hari
        if (!$this->isAddOrEdit() && $this->jumlah_hari->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->jumlah_hari->AdvancedSearch->SearchValue != "" || $this->jumlah_hari->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // tempat
        if (!$this->isAddOrEdit() && $this->tempat->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->tempat->AdvancedSearch->SearchValue != "" || $this->tempat->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // jumlah_peserta
        if (!$this->isAddOrEdit() && $this->jumlah_peserta->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->jumlah_peserta->AdvancedSearch->SearchValue != "" || $this->jumlah_peserta->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // sisa
        if (!$this->isAddOrEdit() && $this->sisa->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->sisa->AdvancedSearch->SearchValue != "" || $this->sisa->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // harga
        if (!$this->isAddOrEdit() && $this->harga->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->harga->AdvancedSearch->SearchValue != "" || $this->harga->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // tawal
        if (!$this->isAddOrEdit() && $this->tawal->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->tawal->AdvancedSearch->SearchValue != "" || $this->tawal->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // takhir
        if (!$this->isAddOrEdit() && $this->takhir->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->takhir->AdvancedSearch->SearchValue != "" || $this->takhir->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // tanggal_pelaksanaan
        if (!$this->isAddOrEdit() && $this->tanggal_pelaksanaan->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->tanggal_pelaksanaan->AdvancedSearch->SearchValue != "" || $this->tanggal_pelaksanaan->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // gambar
        if (!$this->isAddOrEdit() && $this->gambar->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->gambar->AdvancedSearch->SearchValue != "" || $this->gambar->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // kategori
        if (!$this->isAddOrEdit() && $this->kategori->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->kategori->AdvancedSearch->SearchValue != "" || $this->kategori->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // tujuan
        if (!$this->isAddOrEdit() && $this->tujuan->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->tujuan->AdvancedSearch->SearchValue != "" || $this->tujuan->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // sub_kategori
        if (!$this->isAddOrEdit() && $this->sub_kategori->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->sub_kategori->AdvancedSearch->SearchValue != "" || $this->sub_kategori->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // topik_bahasan
        if (!$this->isAddOrEdit() && $this->topik_bahasan->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->topik_bahasan->AdvancedSearch->SearchValue != "" || $this->topik_bahasan->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // catatan
        if (!$this->isAddOrEdit() && $this->catatan->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->catatan->AdvancedSearch->SearchValue != "" || $this->catatan->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // Link
        if (!$this->isAddOrEdit() && $this->Link->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->Link->AdvancedSearch->SearchValue != "" || $this->Link->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // Last_Updated
        if (!$this->isAddOrEdit() && $this->Last_Updated->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->Last_Updated->AdvancedSearch->SearchValue != "" || $this->Last_Updated->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // Created_Date
        if (!$this->isAddOrEdit() && $this->Created_Date->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->Created_Date->AdvancedSearch->SearchValue != "" || $this->Created_Date->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // Activated
        if (!$this->isAddOrEdit() && $this->Activated->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->Activated->AdvancedSearch->SearchValue != "" || $this->Activated->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        if (is_array($this->Activated->AdvancedSearch->SearchValue)) {
            $this->Activated->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->Activated->AdvancedSearch->SearchValue);
        }
        if (is_array($this->Activated->AdvancedSearch->SearchValue2)) {
            $this->Activated->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->Activated->AdvancedSearch->SearchValue2);
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
        $this->pelatihan_id->setDbValue($row['pelatihan_id']);
        $this->jenis_pelatihan->setDbValue($row['jenis_pelatihan']);
        $this->judul_pelatihan->setDbValue($row['judul_pelatihan']);
        $this->jumlah_hari->setDbValue($row['jumlah_hari']);
        $this->tempat->setDbValue($row['tempat']);
        $this->jumlah_peserta->setDbValue($row['jumlah_peserta']);
        $this->sisa->setDbValue($row['sisa']);
        $this->harga->setDbValue($row['harga']);
        $this->tawal->setDbValue($row['tawal']);
        $this->takhir->setDbValue($row['takhir']);
        $this->tanggal_pelaksanaan->setDbValue($row['tanggal_pelaksanaan']);
        $this->gambar->Upload->DbValue = $row['gambar'];
        $this->gambar->setDbValue($this->gambar->Upload->DbValue);
        $this->kategori->setDbValue($row['kategori']);
        $this->tujuan->setDbValue($row['tujuan']);
        $this->sub_kategori->setDbValue($row['sub_kategori']);
        $this->topik_bahasan->setDbValue($row['topik_bahasan']);
        $this->catatan->setDbValue($row['catatan']);
        $this->Link->setDbValue($row['Link']);
        $this->Last_Updated->setDbValue($row['Last_Updated']);
        $this->Created_Date->setDbValue($row['Created_Date']);
        $this->Activated->setDbValue($row['Activated']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['pelatihan_id'] = null;
        $row['jenis_pelatihan'] = null;
        $row['judul_pelatihan'] = null;
        $row['jumlah_hari'] = null;
        $row['tempat'] = null;
        $row['jumlah_peserta'] = null;
        $row['sisa'] = null;
        $row['harga'] = null;
        $row['tawal'] = null;
        $row['takhir'] = null;
        $row['tanggal_pelaksanaan'] = null;
        $row['gambar'] = null;
        $row['kategori'] = null;
        $row['tujuan'] = null;
        $row['sub_kategori'] = null;
        $row['topik_bahasan'] = null;
        $row['catatan'] = null;
        $row['Link'] = null;
        $row['Last_Updated'] = null;
        $row['Created_Date'] = null;
        $row['Activated'] = null;
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

        // Convert decimal values if posted back
        if ($this->harga->FormValue == $this->harga->CurrentValue && is_numeric(ConvertToFloatString($this->harga->CurrentValue))) {
            $this->harga->CurrentValue = ConvertToFloatString($this->harga->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // pelatihan_id

        // jenis_pelatihan

        // judul_pelatihan

        // jumlah_hari

        // tempat

        // jumlah_peserta

        // sisa

        // harga

        // tawal

        // takhir

        // tanggal_pelaksanaan

        // gambar

        // kategori

        // tujuan

        // sub_kategori

        // topik_bahasan

        // catatan

        // Link

        // Last_Updated

        // Created_Date

        // Activated
        if ($this->RowType == ROWTYPE_VIEW) {
            // pelatihan_id
            $this->pelatihan_id->ViewValue = $this->pelatihan_id->CurrentValue;
            $this->pelatihan_id->ViewCustomAttributes = "";

            // jenis_pelatihan
            if (strval($this->jenis_pelatihan->CurrentValue) != "") {
                $this->jenis_pelatihan->ViewValue = $this->jenis_pelatihan->optionCaption($this->jenis_pelatihan->CurrentValue);
            } else {
                $this->jenis_pelatihan->ViewValue = null;
            }
            $this->jenis_pelatihan->ViewCustomAttributes = "";

            // judul_pelatihan
            $this->judul_pelatihan->ViewValue = $this->judul_pelatihan->CurrentValue;
            $this->judul_pelatihan->ViewCustomAttributes = "";

            // jumlah_hari
            $this->jumlah_hari->ViewValue = $this->jumlah_hari->CurrentValue;
            $this->jumlah_hari->ViewCustomAttributes = "";

            // tempat
            $this->tempat->ViewValue = $this->tempat->CurrentValue;
            $this->tempat->ViewCustomAttributes = "";

            // jumlah_peserta
            $this->jumlah_peserta->ViewValue = $this->jumlah_peserta->CurrentValue;
            $this->jumlah_peserta->ViewValue = FormatNumber($this->jumlah_peserta->ViewValue, 0, -2, -2, -2);
            $this->jumlah_peserta->ViewCustomAttributes = "";

            // sisa
            $this->sisa->ViewValue = $this->sisa->CurrentValue;
            $this->sisa->ViewValue = FormatNumber($this->sisa->ViewValue, 0, -2, -2, -2);
            $this->sisa->ViewCustomAttributes = "";

            // harga
            $this->harga->ViewValue = $this->harga->CurrentValue;
            $this->harga->ViewValue = FormatNumber($this->harga->ViewValue, 2, -2, -2, -2);
            $this->harga->ViewCustomAttributes = "";

            // tawal
            $this->tawal->ViewValue = $this->tawal->CurrentValue;
            $this->tawal->ViewValue = FormatDateTime($this->tawal->ViewValue, 7);
            $this->tawal->ViewCustomAttributes = "style='width:190px;'";

            // takhir
            $this->takhir->ViewValue = $this->takhir->CurrentValue;
            $this->takhir->ViewValue = FormatDateTime($this->takhir->ViewValue, 7);
            $this->takhir->ViewCustomAttributes = "style='width:190px;'";

            // tanggal_pelaksanaan
            $this->tanggal_pelaksanaan->ViewValue = $this->tanggal_pelaksanaan->CurrentValue;
            $this->tanggal_pelaksanaan->ViewCustomAttributes = "";

            // gambar
            if (!EmptyValue($this->gambar->Upload->DbValue)) {
                $this->gambar->ImageAlt = $this->gambar->alt();
                $this->gambar->ViewValue = $this->gambar->Upload->DbValue;
            } else {
                $this->gambar->ViewValue = "";
            }
            $this->gambar->ViewCustomAttributes = "style='width:100%;'";

            // kategori
            $this->kategori->ViewValue = $this->kategori->CurrentValue;
            $this->kategori->ViewCustomAttributes = "";

            // sub_kategori
            $this->sub_kategori->ViewValue = $this->sub_kategori->CurrentValue;
            $this->sub_kategori->ViewCustomAttributes = "";

            // Last_Updated
            $this->Last_Updated->ViewValue = $this->Last_Updated->CurrentValue;
            $this->Last_Updated->ViewValue = FormatDateTime($this->Last_Updated->ViewValue, 0);
            $this->Last_Updated->ViewCustomAttributes = "";

            // Created_Date
            $this->Created_Date->ViewValue = $this->Created_Date->CurrentValue;
            $this->Created_Date->ViewValue = FormatDateTime($this->Created_Date->ViewValue, 0);
            $this->Created_Date->ViewCustomAttributes = "";

            // Activated
            if (ConvertToBool($this->Activated->CurrentValue)) {
                $this->Activated->ViewValue = $this->Activated->tagCaption(1) != "" ? $this->Activated->tagCaption(1) : "Y";
            } else {
                $this->Activated->ViewValue = $this->Activated->tagCaption(2) != "" ? $this->Activated->tagCaption(2) : "N";
            }
            $this->Activated->ViewCustomAttributes = "";

            // pelatihan_id
            $this->pelatihan_id->LinkCustomAttributes = "";
            $this->pelatihan_id->HrefValue = "";
            $this->pelatihan_id->TooltipValue = "";

            // jenis_pelatihan
            $this->jenis_pelatihan->LinkCustomAttributes = "";
            $this->jenis_pelatihan->HrefValue = "";
            $this->jenis_pelatihan->TooltipValue = "";

            // judul_pelatihan
            $this->judul_pelatihan->LinkCustomAttributes = "";
            $this->judul_pelatihan->HrefValue = "";
            $this->judul_pelatihan->TooltipValue = "";

            // jumlah_hari
            $this->jumlah_hari->LinkCustomAttributes = "";
            $this->jumlah_hari->HrefValue = "";
            $this->jumlah_hari->TooltipValue = "";

            // tempat
            $this->tempat->LinkCustomAttributes = "";
            $this->tempat->HrefValue = "";
            $this->tempat->TooltipValue = "";

            // jumlah_peserta
            $this->jumlah_peserta->LinkCustomAttributes = "";
            $this->jumlah_peserta->HrefValue = "";
            $this->jumlah_peserta->TooltipValue = "";

            // sisa
            $this->sisa->LinkCustomAttributes = "";
            $this->sisa->HrefValue = "";
            $this->sisa->TooltipValue = "";

            // harga
            $this->harga->LinkCustomAttributes = "";
            $this->harga->HrefValue = "";
            $this->harga->TooltipValue = "";

            // tanggal_pelaksanaan
            $this->tanggal_pelaksanaan->LinkCustomAttributes = "";
            $this->tanggal_pelaksanaan->HrefValue = "";
            $this->tanggal_pelaksanaan->TooltipValue = "";

            // gambar
            $this->gambar->LinkCustomAttributes = "";
            if (!EmptyValue($this->gambar->Upload->DbValue)) {
                $this->gambar->HrefValue = GetFileUploadUrl($this->gambar, $this->gambar->htmlDecode($this->gambar->Upload->DbValue)); // Add prefix/suffix
                $this->gambar->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->gambar->HrefValue = FullUrl($this->gambar->HrefValue, "href");
                }
            } else {
                $this->gambar->HrefValue = "";
            }
            $this->gambar->ExportHrefValue = $this->gambar->UploadPath . $this->gambar->Upload->DbValue;
            $this->gambar->TooltipValue = "";
            if ($this->gambar->UseColorbox) {
                if (EmptyValue($this->gambar->TooltipValue)) {
                    $this->gambar->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->gambar->LinkAttrs["data-rel"] = "w_pelatihan_x" . $this->RowCount . "_gambar";
                $this->gambar->LinkAttrs->appendClass("ew-lightbox");
            }

            // kategori
            $this->kategori->LinkCustomAttributes = "";
            $this->kategori->HrefValue = "";
            $this->kategori->TooltipValue = "";

            // Activated
            $this->Activated->LinkCustomAttributes = "";
            $this->Activated->HrefValue = "";
            $this->Activated->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
            // pelatihan_id
            $this->pelatihan_id->EditAttrs["class"] = "form-control";
            $this->pelatihan_id->EditCustomAttributes = "";
            $this->pelatihan_id->EditValue = HtmlEncode($this->pelatihan_id->AdvancedSearch->SearchValue);
            $this->pelatihan_id->PlaceHolder = RemoveHtml($this->pelatihan_id->caption());

            // jenis_pelatihan
            $this->jenis_pelatihan->EditAttrs["class"] = "form-control";
            $this->jenis_pelatihan->EditCustomAttributes = "";
            $this->jenis_pelatihan->EditValue = $this->jenis_pelatihan->options(true);
            $this->jenis_pelatihan->PlaceHolder = RemoveHtml($this->jenis_pelatihan->caption());

            // judul_pelatihan
            $this->judul_pelatihan->EditAttrs["class"] = "form-control";
            $this->judul_pelatihan->EditCustomAttributes = "";
            if (!$this->judul_pelatihan->Raw) {
                $this->judul_pelatihan->AdvancedSearch->SearchValue = HtmlDecode($this->judul_pelatihan->AdvancedSearch->SearchValue);
            }
            $this->judul_pelatihan->EditValue = HtmlEncode($this->judul_pelatihan->AdvancedSearch->SearchValue);
            $this->judul_pelatihan->PlaceHolder = RemoveHtml($this->judul_pelatihan->caption());

            // jumlah_hari
            $this->jumlah_hari->EditAttrs["class"] = "form-control";
            $this->jumlah_hari->EditCustomAttributes = "";
            if (!$this->jumlah_hari->Raw) {
                $this->jumlah_hari->AdvancedSearch->SearchValue = HtmlDecode($this->jumlah_hari->AdvancedSearch->SearchValue);
            }
            $this->jumlah_hari->EditValue = HtmlEncode($this->jumlah_hari->AdvancedSearch->SearchValue);
            $this->jumlah_hari->PlaceHolder = RemoveHtml($this->jumlah_hari->caption());

            // tempat
            $this->tempat->EditAttrs["class"] = "form-control";
            $this->tempat->EditCustomAttributes = "";
            if (!$this->tempat->Raw) {
                $this->tempat->AdvancedSearch->SearchValue = HtmlDecode($this->tempat->AdvancedSearch->SearchValue);
            }
            $this->tempat->EditValue = HtmlEncode($this->tempat->AdvancedSearch->SearchValue);
            $this->tempat->PlaceHolder = RemoveHtml($this->tempat->caption());

            // jumlah_peserta
            $this->jumlah_peserta->EditAttrs["class"] = "form-control";
            $this->jumlah_peserta->EditCustomAttributes = "";
            $this->jumlah_peserta->EditValue = HtmlEncode($this->jumlah_peserta->AdvancedSearch->SearchValue);
            $this->jumlah_peserta->PlaceHolder = RemoveHtml($this->jumlah_peserta->caption());

            // sisa
            $this->sisa->EditAttrs["class"] = "form-control";
            $this->sisa->EditCustomAttributes = "";
            $this->sisa->EditValue = HtmlEncode($this->sisa->AdvancedSearch->SearchValue);
            $this->sisa->PlaceHolder = RemoveHtml($this->sisa->caption());

            // harga
            $this->harga->EditAttrs["class"] = "form-control";
            $this->harga->EditCustomAttributes = "";
            $this->harga->EditValue = HtmlEncode($this->harga->AdvancedSearch->SearchValue);
            $this->harga->PlaceHolder = RemoveHtml($this->harga->caption());

            // tanggal_pelaksanaan
            $this->tanggal_pelaksanaan->EditAttrs["class"] = "form-control";
            $this->tanggal_pelaksanaan->EditCustomAttributes = "";
            if (!$this->tanggal_pelaksanaan->Raw) {
                $this->tanggal_pelaksanaan->AdvancedSearch->SearchValue = HtmlDecode($this->tanggal_pelaksanaan->AdvancedSearch->SearchValue);
            }
            $this->tanggal_pelaksanaan->EditValue = HtmlEncode($this->tanggal_pelaksanaan->AdvancedSearch->SearchValue);
            $this->tanggal_pelaksanaan->PlaceHolder = RemoveHtml($this->tanggal_pelaksanaan->caption());

            // gambar
            $this->gambar->EditAttrs["class"] = "form-control";
            $this->gambar->EditCustomAttributes = "";
            if (!$this->gambar->Raw) {
                $this->gambar->AdvancedSearch->SearchValue = HtmlDecode($this->gambar->AdvancedSearch->SearchValue);
            }
            $this->gambar->EditValue = HtmlEncode($this->gambar->AdvancedSearch->SearchValue);
            $this->gambar->PlaceHolder = RemoveHtml($this->gambar->caption());

            // kategori
            $this->kategori->EditAttrs["class"] = "form-control";
            $this->kategori->EditCustomAttributes = "";
            if (!$this->kategori->Raw) {
                $this->kategori->AdvancedSearch->SearchValue = HtmlDecode($this->kategori->AdvancedSearch->SearchValue);
            }
            $this->kategori->EditValue = HtmlEncode($this->kategori->AdvancedSearch->SearchValue);
            $this->kategori->PlaceHolder = RemoveHtml($this->kategori->caption());

            // Activated
            $this->Activated->EditCustomAttributes = "";
            $this->Activated->EditValue = $this->Activated->options(false);
            $this->Activated->PlaceHolder = RemoveHtml($this->Activated->caption());
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
        $this->pelatihan_id->AdvancedSearch->load();
        $this->jenis_pelatihan->AdvancedSearch->load();
        $this->judul_pelatihan->AdvancedSearch->load();
        $this->jumlah_hari->AdvancedSearch->load();
        $this->tempat->AdvancedSearch->load();
        $this->jumlah_peserta->AdvancedSearch->load();
        $this->sisa->AdvancedSearch->load();
        $this->harga->AdvancedSearch->load();
        $this->tawal->AdvancedSearch->load();
        $this->takhir->AdvancedSearch->load();
        $this->tanggal_pelaksanaan->AdvancedSearch->load();
        $this->gambar->AdvancedSearch->load();
        $this->kategori->AdvancedSearch->load();
        $this->tujuan->AdvancedSearch->load();
        $this->sub_kategori->AdvancedSearch->load();
        $this->topik_bahasan->AdvancedSearch->load();
        $this->catatan->AdvancedSearch->load();
        $this->Link->AdvancedSearch->load();
        $this->Last_Updated->AdvancedSearch->load();
        $this->Created_Date->AdvancedSearch->load();
        $this->Activated->AdvancedSearch->load();
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fw_pelatihanlistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
                case "x_jenis_pelatihan":
                    break;
                case "x_Activated":
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
        $this->jenis_pelatihan->Visible = FALSE;
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
        // Example:
        //$opt = &$this->ListOptions->Add("new");
        //$opt->Header = "xxx";
        //$opt->OnLeft = true; // Link on left
        //$opt->MoveTo(0); // Move to first column
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
        // Example:
        //$this->ListOptions["new"]->Body = "xxx";
    }

    // Row Custom Action event
    public function rowCustomAction($action, $row)
    {
        // Return false to abort
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
