<?php

namespace PHPMaker2021\ppejp_web;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class WPelatihanView extends WPelatihan
{
    use MessagesTrait;

    // Page ID
    public $PageID = "view";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'w_pelatihan';

    // Page object name
    public $PageObjName = "WPelatihanView";

    // Rendering View
    public $RenderingView = false;

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
    public $ExportExcelCustom = true;
    public $ExportWordCustom = true;
    public $ExportPdfCustom = true;
    public $ExportEmailCustom = true;

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

        // Custom template
        $this->UseCustomTemplate = true;

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
        if (($keyValue = Get("pelatihan_id") ?? Route("pelatihan_id")) !== null) {
            $this->RecKey["pelatihan_id"] = $keyValue;
        }
        $this->ExportPrintUrl = $pageUrl . "export=print";
        $this->ExportHtmlUrl = $pageUrl . "export=html";
        $this->ExportExcelUrl = $pageUrl . "export=excel";
        $this->ExportWordUrl = $pageUrl . "export=word";
        $this->ExportXmlUrl = $pageUrl . "export=xml";
        $this->ExportCsvUrl = $pageUrl . "export=csv";
        $this->ExportPdfUrl = $pageUrl . "export=pdf";

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

        // Export options
        $this->ExportOptions = new ListOptions("div");
        $this->ExportOptions->TagClassName = "ew-export-option";

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["action"] = new ListOptions("div");
        $this->OtherOptions["action"]->TagClassName = "ew-action-option";
        $this->OtherOptions["detail"] = new ListOptions("div");
        $this->OtherOptions["detail"]->TagClassName = "ew-detail-option";
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
        global $OldSkipHeaderFooter, $SkipHeaderFooter;
        $SkipHeaderFooter = $OldSkipHeaderFooter;
        if (Post("customexport") === null) {
             // Page Unload event
            if (method_exists($this, "pageUnload")) {
                $this->pageUnload();
            }

            // Global Page Unloaded event (in userfn*.php)
            Page_Unloaded();
        }

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            if (is_array(Session(SESSION_TEMP_IMAGES))) { // Restore temp images
                $TempImages = Session(SESSION_TEMP_IMAGES);
            }
            if (Post("data") !== null) {
                $content = Post("data");
            }
            $ExportFileName = Post("filename", "");
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
        if ($this->CustomExport) { // Save temp images array for custom export
            if (is_array($TempImages)) {
                $_SESSION[SESSION_TEMP_IMAGES] = $TempImages;
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
                    if ($pageName == "wpelatihanview") {
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
    public $ExportOptions; // Export options
    public $OtherOptions; // Other options
    public $DisplayRecords = 1;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecKey = [];
    public $IsModal = false;

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
        $this->CurrentAction = Param("action"); // Set up current action
        global $OldSkipHeaderFooter, $SkipHeaderFooter;
        $OldSkipHeaderFooter = $SkipHeaderFooter;
        $SkipHeaderFooter = true;
        $this->pelatihan_id->setVisibility();
        $this->jenis_pelatihan->setVisibility();
        $this->judul_pelatihan->setVisibility();
        $this->jumlah_hari->setVisibility();
        $this->tempat->setVisibility();
        $this->jumlah_peserta->setVisibility();
        $this->sisa->setVisibility();
        $this->harga->setVisibility();
        $this->tawal->setVisibility();
        $this->takhir->setVisibility();
        $this->tanggal_pelaksanaan->setVisibility();
        $this->gambar->setVisibility();
        $this->kategori->setVisibility();
        $this->tujuan->setVisibility();
        $this->sub_kategori->setVisibility();
        $this->topik_bahasan->setVisibility();
        $this->catatan->setVisibility();
        $this->Link->setVisibility();
        $this->Last_Updated->setVisibility();
        $this->Created_Date->setVisibility();
        $this->Activated->setVisibility();
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

        // Load current record
        $loadCurrentRecord = false;
        $returnUrl = "";
        $matchRecord = false;
        if ($this->isPageRequest()) { // Validate request
            if (($keyValue = Get("pelatihan_id") ?? Route("pelatihan_id")) !== null) {
                $this->pelatihan_id->setQueryStringValue($keyValue);
                $this->RecKey["pelatihan_id"] = $this->pelatihan_id->QueryStringValue;
            } elseif (Post("pelatihan_id") !== null) {
                $this->pelatihan_id->setFormValue(Post("pelatihan_id"));
                $this->RecKey["pelatihan_id"] = $this->pelatihan_id->FormValue;
            } elseif (IsApi() && ($keyValue = Key(0) ?? Route(2)) !== null) {
                $this->pelatihan_id->setQueryStringValue($keyValue);
                $this->RecKey["pelatihan_id"] = $this->pelatihan_id->QueryStringValue;
            } else {
                $returnUrl = "wpelatihanlist"; // Return to list
            }

            // Get action
            $this->CurrentAction = "show"; // Display
            switch ($this->CurrentAction) {
                case "show": // Get a record to display

                    // Load record based on key
                    if (IsApi()) {
                        $filter = $this->getRecordFilter();
                        $this->CurrentFilter = $filter;
                        $sql = $this->getCurrentSql();
                        $conn = $this->getConnection();
                        $this->Recordset = LoadRecordset($sql, $conn);
                        $res = $this->Recordset && !$this->Recordset->EOF;
                    } else {
                        $res = $this->loadRow();
                    }
                    if (!$res) { // Load record based on key
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $returnUrl = "wpelatihanlist"; // No matching record, return to list
                    }
                    break;
            }
        } else {
            $returnUrl = "wpelatihanlist"; // Not page request, return to list
        }
        if ($returnUrl != "") {
            $this->terminate($returnUrl);
            return;
        }

        // Set up Breadcrumb
        if (!$this->isExport()) {
            $this->setupBreadcrumb();
        }

        // Render row
        $this->RowType = ROWTYPE_VIEW;
        $this->resetAttributes();
        $this->renderRow();

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset, true); // Get current record only
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows]);
            $this->terminate(true);
            return;
        }

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

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("ViewPageAddLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,url:'" . HtmlEncode(GetUrl($this->AddUrl)) . "'});\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        }
        $item->Visible = ($this->AddUrl != "" && $Security->canAdd());

        // Edit
        $item = &$option->add("edit");
        $editcaption = HtmlTitle($Language->phrase("ViewPageEditLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,url:'" . HtmlEncode(GetUrl($this->EditUrl)) . "'});\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        }
        $item->Visible = ($this->EditUrl != "" && $Security->canEdit());

        // Delete
        $item = &$option->add("delete");
        if ($this->IsModal) { // Handle as inline delete
            $item->Body = "<a onclick=\"return ew.confirmDelete(this);\" class=\"ew-action ew-delete\" title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" href=\"" . HtmlEncode(UrlAddQuery(GetUrl($this->DeleteUrl), "action=1")) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-delete\" title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        }
        $item->Visible = ($this->DeleteUrl != "" && $Security->canDelete());

        // Set up action default
        $option = $options["action"];
        $option->DropDownButtonPhrase = $Language->phrase("ButtonActions");
        $option->UseDropDownButton = true;
        $option->UseButtonGroup = true;
        $item = &$option->add($option->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
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

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs
        $this->AddUrl = $this->getAddUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();
        $this->ListUrl = $this->getListUrl();
        $this->setupOtherOptions();

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

            // tujuan
            $this->tujuan->ViewValue = $this->tujuan->CurrentValue;
            $this->tujuan->ViewCustomAttributes = "";

            // sub_kategori
            $this->sub_kategori->ViewValue = $this->sub_kategori->CurrentValue;
            $this->sub_kategori->ViewCustomAttributes = "";

            // topik_bahasan
            $this->topik_bahasan->ViewValue = $this->topik_bahasan->CurrentValue;
            $this->topik_bahasan->ViewCustomAttributes = "";

            // catatan
            $this->catatan->ViewValue = $this->catatan->CurrentValue;
            $this->catatan->ViewCustomAttributes = "";

            // Link
            $this->Link->ViewValue = $this->Link->CurrentValue;
            $this->Link->ViewCustomAttributes = "";

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

            // tawal
            $this->tawal->LinkCustomAttributes = "";
            $this->tawal->HrefValue = "";
            $this->tawal->TooltipValue = "";

            // takhir
            $this->takhir->LinkCustomAttributes = "";
            $this->takhir->HrefValue = "";
            $this->takhir->TooltipValue = "";

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
                $this->gambar->LinkAttrs["data-rel"] = "w_pelatihan_x_gambar";
                $this->gambar->LinkAttrs->appendClass("ew-lightbox");
            }

            // kategori
            $this->kategori->LinkCustomAttributes = "";
            $this->kategori->HrefValue = "";
            $this->kategori->TooltipValue = "";

            // tujuan
            $this->tujuan->LinkCustomAttributes = "";
            $this->tujuan->HrefValue = "";
            $this->tujuan->TooltipValue = "";

            // sub_kategori
            $this->sub_kategori->LinkCustomAttributes = "";
            $this->sub_kategori->HrefValue = "";
            $this->sub_kategori->TooltipValue = "";

            // topik_bahasan
            $this->topik_bahasan->LinkCustomAttributes = "";
            $this->topik_bahasan->HrefValue = "";
            $this->topik_bahasan->TooltipValue = "";

            // catatan
            $this->catatan->LinkCustomAttributes = "";
            $this->catatan->HrefValue = "";
            $this->catatan->TooltipValue = "";

            // Link
            $this->Link->LinkCustomAttributes = "";
            $this->Link->HrefValue = "";
            $this->Link->TooltipValue = "";

            // Last_Updated
            $this->Last_Updated->LinkCustomAttributes = "";
            $this->Last_Updated->HrefValue = "";
            $this->Last_Updated->TooltipValue = "";

            // Created_Date
            $this->Created_Date->LinkCustomAttributes = "";
            $this->Created_Date->HrefValue = "";
            $this->Created_Date->TooltipValue = "";

            // Activated
            $this->Activated->LinkCustomAttributes = "";
            $this->Activated->HrefValue = "";
            $this->Activated->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }

        // Save data for Custom Template
        if ($this->RowType == ROWTYPE_VIEW || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_ADD) {
            $this->Rows[] = $this->customTemplateFieldValues();
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("wpelatihanlist"), "", $this->TableVar, true);
        $pageId = "view";
        $Breadcrumb->add("view", $pageId, $url);
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
        if($this->jenis_pelatihan->CurrentValue == "obrolan_ekspor") { $url = GetUrl("obrolan-ekspor"); }
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
}
