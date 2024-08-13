<?php

namespace PHPMaker2021\ppejp_web;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class WBeritaAdd extends WBerita
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'w_berita';

    // Page object name
    public $PageObjName = "WBeritaAdd";

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

        // Table object (w_berita)
        if (!isset($GLOBALS["w_berita"]) || get_class($GLOBALS["w_berita"]) == PROJECT_NAMESPACE . "w_berita") {
            $GLOBALS["w_berita"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'w_berita');
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
                $doc = new $class(Container("w_berita"));
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
                    if ($pageName == "wberitaview") {
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
		        $this->gambar->OldUploadPath = "images/news/";
		        $this->gambar->UploadPath = $this->gambar->OldUploadPath;
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
            $key .= @$ar['id'];
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
            $this->id->Visible = false;
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
    public $FormClassName = "ew-horizontal ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;

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
        $this->id->Visible = false;
        $this->judul->setVisibility();
        $this->url_berita->Visible = false;
        $this->isi->setVisibility();
        $this->kategori_id->setVisibility();
        $this->tanggal_publikasi->setVisibility();
        $this->penulis->setVisibility();
        $this->gambar->setVisibility();
        $this->created_at->setVisibility();
        $this->updated_at->Visible = false;
        $this->user_created->setVisibility();
        $this->user_updated->Visible = false;
        $this->publish->setVisibility();
        $this->gambar2->Visible = false;
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
        $this->setupLookupOptions($this->kategori_id);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-add-form ew-horizontal";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("id") ?? Route("id")) !== null) {
                $this->id->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("wberitalist"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "wberitalist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "wberitaview") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = ROWTYPE_ADD; // Render add type

        // Render row
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
        $this->gambar->Upload->Index = $CurrentForm->Index;
        $this->gambar->Upload->uploadFile();
        $this->gambar->CurrentValue = $this->gambar->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->judul->CurrentValue = null;
        $this->judul->OldValue = $this->judul->CurrentValue;
        $this->url_berita->CurrentValue = null;
        $this->url_berita->OldValue = $this->url_berita->CurrentValue;
        $this->isi->CurrentValue = null;
        $this->isi->OldValue = $this->isi->CurrentValue;
        $this->kategori_id->CurrentValue = null;
        $this->kategori_id->OldValue = $this->kategori_id->CurrentValue;
        $this->tanggal_publikasi->CurrentValue = null;
        $this->tanggal_publikasi->OldValue = $this->tanggal_publikasi->CurrentValue;
        $this->penulis->CurrentValue = null;
        $this->penulis->OldValue = $this->penulis->CurrentValue;
        $this->gambar->Upload->DbValue = null;
        $this->gambar->OldValue = $this->gambar->Upload->DbValue;
        $this->gambar->CurrentValue = null; // Clear file related field
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->updated_at->CurrentValue = null;
        $this->updated_at->OldValue = $this->updated_at->CurrentValue;
        $this->user_created->CurrentValue = null;
        $this->user_created->OldValue = $this->user_created->CurrentValue;
        $this->user_updated->CurrentValue = null;
        $this->user_updated->OldValue = $this->user_updated->CurrentValue;
        $this->publish->CurrentValue = "Y";
        $this->gambar2->CurrentValue = null;
        $this->gambar2->OldValue = $this->gambar2->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'judul' first before field var 'x_judul'
        $val = $CurrentForm->hasValue("judul") ? $CurrentForm->getValue("judul") : $CurrentForm->getValue("x_judul");
        if (!$this->judul->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->judul->Visible = false; // Disable update for API request
            } else {
                $this->judul->setFormValue($val);
            }
        }

        // Check field name 'isi' first before field var 'x_isi'
        $val = $CurrentForm->hasValue("isi") ? $CurrentForm->getValue("isi") : $CurrentForm->getValue("x_isi");
        if (!$this->isi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isi->Visible = false; // Disable update for API request
            } else {
                $this->isi->setFormValue($val);
            }
        }

        // Check field name 'kategori_id' first before field var 'x_kategori_id'
        $val = $CurrentForm->hasValue("kategori_id") ? $CurrentForm->getValue("kategori_id") : $CurrentForm->getValue("x_kategori_id");
        if (!$this->kategori_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kategori_id->Visible = false; // Disable update for API request
            } else {
                $this->kategori_id->setFormValue($val);
            }
        }

        // Check field name 'tanggal_publikasi' first before field var 'x_tanggal_publikasi'
        $val = $CurrentForm->hasValue("tanggal_publikasi") ? $CurrentForm->getValue("tanggal_publikasi") : $CurrentForm->getValue("x_tanggal_publikasi");
        if (!$this->tanggal_publikasi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_publikasi->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_publikasi->setFormValue($val);
            }
            $this->tanggal_publikasi->CurrentValue = UnFormatDateTime($this->tanggal_publikasi->CurrentValue, 14);
        }

        // Check field name 'penulis' first before field var 'x_penulis'
        $val = $CurrentForm->hasValue("penulis") ? $CurrentForm->getValue("penulis") : $CurrentForm->getValue("x_penulis");
        if (!$this->penulis->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->penulis->Visible = false; // Disable update for API request
            } else {
                $this->penulis->setFormValue($val);
            }
        }

        // Check field name 'created_at' first before field var 'x_created_at'
        $val = $CurrentForm->hasValue("created_at") ? $CurrentForm->getValue("created_at") : $CurrentForm->getValue("x_created_at");
        if (!$this->created_at->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->created_at->Visible = false; // Disable update for API request
            } else {
                $this->created_at->setFormValue($val);
            }
            $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 17);
        }

        // Check field name 'user_created' first before field var 'x_user_created'
        $val = $CurrentForm->hasValue("user_created") ? $CurrentForm->getValue("user_created") : $CurrentForm->getValue("x_user_created");
        if (!$this->user_created->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->user_created->Visible = false; // Disable update for API request
            } else {
                $this->user_created->setFormValue($val);
            }
        }

        // Check field name 'publish' first before field var 'x_publish'
        $val = $CurrentForm->hasValue("publish") ? $CurrentForm->getValue("publish") : $CurrentForm->getValue("x_publish");
        if (!$this->publish->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->publish->Visible = false; // Disable update for API request
            } else {
                $this->publish->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
		$this->gambar->OldUploadPath = "images/news/";
		$this->gambar->UploadPath = $this->gambar->OldUploadPath;
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->judul->CurrentValue = $this->judul->FormValue;
        $this->isi->CurrentValue = $this->isi->FormValue;
        $this->kategori_id->CurrentValue = $this->kategori_id->FormValue;
        $this->tanggal_publikasi->CurrentValue = $this->tanggal_publikasi->FormValue;
        $this->tanggal_publikasi->CurrentValue = UnFormatDateTime($this->tanggal_publikasi->CurrentValue, 14);
        $this->penulis->CurrentValue = $this->penulis->FormValue;
        $this->created_at->CurrentValue = $this->created_at->FormValue;
        $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 17);
        $this->user_created->CurrentValue = $this->user_created->FormValue;
        $this->publish->CurrentValue = $this->publish->FormValue;
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
        $this->id->setDbValue($row['id']);
        $this->judul->setDbValue($row['judul']);
        $this->url_berita->setDbValue($row['url_berita']);
        $this->isi->setDbValue($row['isi']);
        $this->kategori_id->setDbValue($row['kategori_id']);
        $this->tanggal_publikasi->setDbValue($row['tanggal_publikasi']);
        $this->penulis->setDbValue($row['penulis']);
        $this->gambar->Upload->DbValue = $row['gambar'];
        $this->gambar->setDbValue($this->gambar->Upload->DbValue);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
        $this->user_created->setDbValue($row['user_created']);
        $this->user_updated->setDbValue($row['user_updated']);
        $this->publish->setDbValue($row['publish']);
        $this->gambar2->setDbValue($row['gambar2']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['judul'] = $this->judul->CurrentValue;
        $row['url_berita'] = $this->url_berita->CurrentValue;
        $row['isi'] = $this->isi->CurrentValue;
        $row['kategori_id'] = $this->kategori_id->CurrentValue;
        $row['tanggal_publikasi'] = $this->tanggal_publikasi->CurrentValue;
        $row['penulis'] = $this->penulis->CurrentValue;
        $row['gambar'] = $this->gambar->Upload->DbValue;
        $row['created_at'] = $this->created_at->CurrentValue;
        $row['updated_at'] = $this->updated_at->CurrentValue;
        $row['user_created'] = $this->user_created->CurrentValue;
        $row['user_updated'] = $this->user_updated->CurrentValue;
        $row['publish'] = $this->publish->CurrentValue;
        $row['gambar2'] = $this->gambar2->CurrentValue;
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

        // id

        // judul

        // url_berita

        // isi

        // kategori_id

        // tanggal_publikasi

        // penulis

        // gambar

        // created_at

        // updated_at

        // user_created

        // user_updated

        // publish

        // gambar2
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // judul
            $this->judul->ViewValue = $this->judul->CurrentValue;
            $this->judul->ViewCustomAttributes = "";

            // url_berita
            $this->url_berita->ViewValue = $this->url_berita->CurrentValue;
            $this->url_berita->ViewCustomAttributes = "";

            // isi
            $this->isi->ViewValue = $this->isi->CurrentValue;
            $this->isi->ViewCustomAttributes = "";

            // kategori_id
            $curVal = trim(strval($this->kategori_id->CurrentValue));
            if ($curVal != "") {
                $this->kategori_id->ViewValue = $this->kategori_id->lookupCacheOption($curVal);
                if ($this->kategori_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->kategori_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kategori_id->Lookup->renderViewRow($rswrk[0]);
                        $this->kategori_id->ViewValue = $this->kategori_id->displayValue($arwrk);
                    } else {
                        $this->kategori_id->ViewValue = $this->kategori_id->CurrentValue;
                    }
                }
            } else {
                $this->kategori_id->ViewValue = null;
            }
            $this->kategori_id->ViewCustomAttributes = "";

            // tanggal_publikasi
            $this->tanggal_publikasi->ViewValue = $this->tanggal_publikasi->CurrentValue;
            $this->tanggal_publikasi->ViewValue = FormatDateTime($this->tanggal_publikasi->ViewValue, 14);
            $this->tanggal_publikasi->ViewCustomAttributes = "";

            // penulis
            $this->penulis->ViewValue = $this->penulis->CurrentValue;
            $this->penulis->ViewCustomAttributes = "";

            // gambar
            $this->gambar->UploadPath = "images/news/";
            if (!EmptyValue($this->gambar->Upload->DbValue)) {
                $this->gambar->ImageWidth = 500;
                $this->gambar->ImageHeight = 281;
                $this->gambar->ImageAlt = $this->gambar->alt();
                $this->gambar->ViewValue = $this->gambar->Upload->DbValue;
            } else {
                $this->gambar->ViewValue = "";
            }
            $this->gambar->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 17);
            $this->created_at->CssClass = "font-italic";
            $this->created_at->CellCssStyle .= "text-align: justify;";
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // user_created
            $this->user_created->ViewValue = $this->user_created->CurrentValue;
            $this->user_created->ViewCustomAttributes = "";

            // user_updated
            $this->user_updated->ViewValue = $this->user_updated->CurrentValue;
            $this->user_updated->ViewCustomAttributes = "";

            // publish
            if (ConvertToBool($this->publish->CurrentValue)) {
                $this->publish->ViewValue = $this->publish->tagCaption(1) != "" ? $this->publish->tagCaption(1) : "Ya";
            } else {
                $this->publish->ViewValue = $this->publish->tagCaption(2) != "" ? $this->publish->tagCaption(2) : "Tidak";
            }
            $this->publish->ViewCustomAttributes = "";

            // gambar2
            $this->gambar2->ViewValue = $this->gambar2->CurrentValue;
            $this->gambar2->ViewValue = FormatNumber($this->gambar2->ViewValue, 0, -2, -2, -2);
            $this->gambar2->ViewCustomAttributes = "";

            // judul
            $this->judul->LinkCustomAttributes = "";
            $this->judul->HrefValue = "";
            $this->judul->TooltipValue = "";

            // isi
            $this->isi->LinkCustomAttributes = "";
            $this->isi->HrefValue = "";
            $this->isi->TooltipValue = "";

            // kategori_id
            $this->kategori_id->LinkCustomAttributes = "";
            $this->kategori_id->HrefValue = "";
            $this->kategori_id->TooltipValue = "";

            // tanggal_publikasi
            $this->tanggal_publikasi->LinkCustomAttributes = "";
            $this->tanggal_publikasi->HrefValue = "";
            $this->tanggal_publikasi->TooltipValue = "";

            // penulis
            $this->penulis->LinkCustomAttributes = "";
            $this->penulis->HrefValue = "";
            $this->penulis->TooltipValue = "";

            // gambar
            $this->gambar->LinkCustomAttributes = "";
            $this->gambar->UploadPath = "images/news/";
            if (!EmptyValue($this->gambar->Upload->DbValue)) {
                $this->gambar->HrefValue = "%u"; // Add prefix/suffix
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
                $this->gambar->LinkAttrs["data-rel"] = "w_berita_x_gambar";
                $this->gambar->LinkAttrs->appendClass("ew-lightbox");
            }

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
            $this->created_at->TooltipValue = "";

            // user_created
            $this->user_created->LinkCustomAttributes = "";
            $this->user_created->HrefValue = "";
            $this->user_created->TooltipValue = "";

            // publish
            $this->publish->LinkCustomAttributes = "";
            $this->publish->HrefValue = "";
            $this->publish->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // judul
            $this->judul->EditAttrs["class"] = "form-control";
            $this->judul->EditCustomAttributes = "";
            if (!$this->judul->Raw) {
                $this->judul->CurrentValue = HtmlDecode($this->judul->CurrentValue);
            }
            $this->judul->EditValue = HtmlEncode($this->judul->CurrentValue);
            $this->judul->PlaceHolder = RemoveHtml($this->judul->caption());

            // isi
            $this->isi->EditAttrs["class"] = "form-control";
            $this->isi->EditCustomAttributes = "";
            $this->isi->EditValue = HtmlEncode($this->isi->CurrentValue);
            $this->isi->PlaceHolder = RemoveHtml($this->isi->caption());

            // kategori_id
            $this->kategori_id->EditAttrs["class"] = "form-control";
            $this->kategori_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->kategori_id->CurrentValue));
            if ($curVal != "") {
                $this->kategori_id->ViewValue = $this->kategori_id->lookupCacheOption($curVal);
            } else {
                $this->kategori_id->ViewValue = $this->kategori_id->Lookup !== null && is_array($this->kategori_id->Lookup->Options) ? $curVal : null;
            }
            if ($this->kategori_id->ViewValue !== null) { // Load from cache
                $this->kategori_id->EditValue = array_values($this->kategori_id->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->kategori_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->kategori_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->kategori_id->EditValue = $arwrk;
            }
            $this->kategori_id->PlaceHolder = RemoveHtml($this->kategori_id->caption());

            // tanggal_publikasi
            $this->tanggal_publikasi->EditAttrs["class"] = "form-control";
            $this->tanggal_publikasi->EditCustomAttributes = "";
            $this->tanggal_publikasi->EditValue = HtmlEncode(FormatDateTime($this->tanggal_publikasi->CurrentValue, 14));
            $this->tanggal_publikasi->PlaceHolder = RemoveHtml($this->tanggal_publikasi->caption());

            // penulis
            $this->penulis->EditAttrs["class"] = "form-control";
            $this->penulis->EditCustomAttributes = "";
            if (!$this->penulis->Raw) {
                $this->penulis->CurrentValue = HtmlDecode($this->penulis->CurrentValue);
            }
            $this->penulis->EditValue = HtmlEncode($this->penulis->CurrentValue);
            $this->penulis->PlaceHolder = RemoveHtml($this->penulis->caption());

            // gambar
            $this->gambar->EditAttrs["class"] = "form-control";
            $this->gambar->EditCustomAttributes = "";
            $this->gambar->UploadPath = "images/news/";
            if (!EmptyValue($this->gambar->Upload->DbValue)) {
                $this->gambar->ImageWidth = 500;
                $this->gambar->ImageHeight = 281;
                $this->gambar->ImageAlt = $this->gambar->alt();
                $this->gambar->EditValue = $this->gambar->Upload->DbValue;
            } else {
                $this->gambar->EditValue = "";
            }
            if (!EmptyValue($this->gambar->CurrentValue)) {
                $this->gambar->Upload->FileName = $this->gambar->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->gambar);
            }

            // created_at

            // user_created

            // publish
            $this->publish->EditCustomAttributes = "";
            $this->publish->EditValue = $this->publish->options(false);
            $this->publish->PlaceHolder = RemoveHtml($this->publish->caption());

            // Add refer script

            // judul
            $this->judul->LinkCustomAttributes = "";
            $this->judul->HrefValue = "";

            // isi
            $this->isi->LinkCustomAttributes = "";
            $this->isi->HrefValue = "";

            // kategori_id
            $this->kategori_id->LinkCustomAttributes = "";
            $this->kategori_id->HrefValue = "";

            // tanggal_publikasi
            $this->tanggal_publikasi->LinkCustomAttributes = "";
            $this->tanggal_publikasi->HrefValue = "";

            // penulis
            $this->penulis->LinkCustomAttributes = "";
            $this->penulis->HrefValue = "";

            // gambar
            $this->gambar->LinkCustomAttributes = "";
            $this->gambar->UploadPath = "images/news/";
            if (!EmptyValue($this->gambar->Upload->DbValue)) {
                $this->gambar->HrefValue = "%u"; // Add prefix/suffix
                $this->gambar->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->gambar->HrefValue = FullUrl($this->gambar->HrefValue, "href");
                }
            } else {
                $this->gambar->HrefValue = "";
            }
            $this->gambar->ExportHrefValue = $this->gambar->UploadPath . $this->gambar->Upload->DbValue;

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";

            // user_created
            $this->user_created->LinkCustomAttributes = "";
            $this->user_created->HrefValue = "";

            // publish
            $this->publish->LinkCustomAttributes = "";
            $this->publish->HrefValue = "";
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
        if ($this->judul->Required) {
            if (!$this->judul->IsDetailKey && EmptyValue($this->judul->FormValue)) {
                $this->judul->addErrorMessage(str_replace("%s", $this->judul->caption(), $this->judul->RequiredErrorMessage));
            }
        }
        if ($this->isi->Required) {
            if (!$this->isi->IsDetailKey && EmptyValue($this->isi->FormValue)) {
                $this->isi->addErrorMessage(str_replace("%s", $this->isi->caption(), $this->isi->RequiredErrorMessage));
            }
        }
        if ($this->kategori_id->Required) {
            if (!$this->kategori_id->IsDetailKey && EmptyValue($this->kategori_id->FormValue)) {
                $this->kategori_id->addErrorMessage(str_replace("%s", $this->kategori_id->caption(), $this->kategori_id->RequiredErrorMessage));
            }
        }
        if ($this->tanggal_publikasi->Required) {
            if (!$this->tanggal_publikasi->IsDetailKey && EmptyValue($this->tanggal_publikasi->FormValue)) {
                $this->tanggal_publikasi->addErrorMessage(str_replace("%s", $this->tanggal_publikasi->caption(), $this->tanggal_publikasi->RequiredErrorMessage));
            }
        }
        if (!CheckShortEuroDate($this->tanggal_publikasi->FormValue)) {
            $this->tanggal_publikasi->addErrorMessage($this->tanggal_publikasi->getErrorMessage(false));
        }
        if ($this->penulis->Required) {
            if (!$this->penulis->IsDetailKey && EmptyValue($this->penulis->FormValue)) {
                $this->penulis->addErrorMessage(str_replace("%s", $this->penulis->caption(), $this->penulis->RequiredErrorMessage));
            }
        }
        if ($this->gambar->Required) {
            if ($this->gambar->Upload->FileName == "" && !$this->gambar->Upload->KeepFile) {
                $this->gambar->addErrorMessage(str_replace("%s", $this->gambar->caption(), $this->gambar->RequiredErrorMessage));
            }
        }
        if ($this->created_at->Required) {
            if (!$this->created_at->IsDetailKey && EmptyValue($this->created_at->FormValue)) {
                $this->created_at->addErrorMessage(str_replace("%s", $this->created_at->caption(), $this->created_at->RequiredErrorMessage));
            }
        }
        if ($this->user_created->Required) {
            if (!$this->user_created->IsDetailKey && EmptyValue($this->user_created->FormValue)) {
                $this->user_created->addErrorMessage(str_replace("%s", $this->user_created->caption(), $this->user_created->RequiredErrorMessage));
            }
        }
        if ($this->publish->Required) {
            if ($this->publish->FormValue == "") {
                $this->publish->addErrorMessage(str_replace("%s", $this->publish->caption(), $this->publish->RequiredErrorMessage));
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
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
            $this->gambar->OldUploadPath = "images/news/";
            $this->gambar->UploadPath = $this->gambar->OldUploadPath;
        }
        $rsnew = [];

        // judul
        $this->judul->setDbValueDef($rsnew, $this->judul->CurrentValue, "", false);

        // isi
        $this->isi->setDbValueDef($rsnew, $this->isi->CurrentValue, "", false);

        // kategori_id
        $this->kategori_id->setDbValueDef($rsnew, $this->kategori_id->CurrentValue, null, false);

        // tanggal_publikasi
        $this->tanggal_publikasi->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_publikasi->CurrentValue, 14), CurrentDate(), false);

        // penulis
        $this->penulis->setDbValueDef($rsnew, $this->penulis->CurrentValue, null, false);

        // gambar
        if ($this->gambar->Visible && !$this->gambar->Upload->KeepFile) {
            $this->gambar->Upload->DbValue = ""; // No need to delete old file
            if ($this->gambar->Upload->FileName == "") {
                $rsnew['gambar'] = null;
            } else {
                $rsnew['gambar'] = $this->gambar->Upload->FileName;
            }
            $this->gambar->ImageWidth = 1920; // Resize width
            $this->gambar->ImageHeight = 1080; // Resize height
        }

        // created_at
        $this->created_at->CurrentValue = CurrentDateTime();
        $this->created_at->setDbValueDef($rsnew, $this->created_at->CurrentValue, null);

        // user_created
        $this->user_created->CurrentValue = CurrentUserID();
        $this->user_created->setDbValueDef($rsnew, $this->user_created->CurrentValue, null);

        // publish
        $tmpBool = $this->publish->CurrentValue;
        if ($tmpBool != "Y" && $tmpBool != "N") {
            $tmpBool = !empty($tmpBool) ? "Y" : "N";
        }
        $this->publish->setDbValueDef($rsnew, $tmpBool, "N", strval($this->publish->CurrentValue) == "");
        if ($this->gambar->Visible && !$this->gambar->Upload->KeepFile) {
            $this->gambar->UploadPath = "images/news/";
            $oldFiles = EmptyValue($this->gambar->Upload->DbValue) ? [] : explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->gambar->htmlDecode(strval($this->gambar->Upload->DbValue)));
            if (!EmptyValue($this->gambar->Upload->FileName)) {
                $newFiles = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), strval($this->gambar->Upload->FileName));
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->gambar, $this->gambar->Upload->Index);
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
                            $file1 = UniqueFilename($this->gambar->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->gambar->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->gambar->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->gambar->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->gambar->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->gambar->setDbValueDef($rsnew, $this->gambar->Upload->FileName, null, false);
            }
        }

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
                if ($this->gambar->Visible && !$this->gambar->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->gambar->Upload->DbValue) ? [] : explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->gambar->htmlDecode(strval($this->gambar->Upload->DbValue)));
                    if (!EmptyValue($this->gambar->Upload->FileName)) {
                        $newFiles = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->gambar->Upload->FileName);
                        $newFiles2 = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->gambar->htmlDecode($rsnew['gambar']));
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->gambar, $this->gambar->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->gambar->Upload->ResizeAndSaveToFile($this->gambar->ImageWidth, $this->gambar->ImageHeight, 100, $newFiles[$i], true, $i)) {
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
                                @unlink($this->gambar->oldPhysicalUploadPath() . $oldFile);
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
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
            // gambar
            CleanUploadTempPath($this->gambar, $this->gambar->Upload->Index);
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
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("wberitalist"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
                case "x_kategori_id":
                    break;
                case "x_publish":
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
