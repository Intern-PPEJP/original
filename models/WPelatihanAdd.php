<?php

namespace PHPMaker2021\ppejp_web;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class WPelatihanAdd extends WPelatihan
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'w_pelatihan';

    // Page object name
    public $PageObjName = "WPelatihanAdd";

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

        // Table object (w_pelatihan)
        if (!isset($GLOBALS["w_pelatihan"]) || get_class($GLOBALS["w_pelatihan"]) == PROJECT_NAMESPACE . "w_pelatihan") {
            $GLOBALS["w_pelatihan"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

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
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->pelatihan_id->Visible = false;
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
        $this->pelatihan_id->Visible = false;
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
        $this->Last_Updated->Visible = false;
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
            if (($keyValue = Get("pelatihan_id") ?? Route("pelatihan_id")) !== null) {
                $this->pelatihan_id->setQueryStringValue($keyValue);
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
                    $this->terminate("wpelatihanlist"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "wpelatihanlist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "wpelatihanview") {
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
        $this->pelatihan_id->CurrentValue = null;
        $this->pelatihan_id->OldValue = $this->pelatihan_id->CurrentValue;
        $this->jenis_pelatihan->CurrentValue = null;
        $this->jenis_pelatihan->OldValue = $this->jenis_pelatihan->CurrentValue;
        $this->judul_pelatihan->CurrentValue = null;
        $this->judul_pelatihan->OldValue = $this->judul_pelatihan->CurrentValue;
        $this->jumlah_hari->CurrentValue = null;
        $this->jumlah_hari->OldValue = $this->jumlah_hari->CurrentValue;
        $this->tempat->CurrentValue = null;
        $this->tempat->OldValue = $this->tempat->CurrentValue;
        $this->jumlah_peserta->CurrentValue = null;
        $this->jumlah_peserta->OldValue = $this->jumlah_peserta->CurrentValue;
        $this->sisa->CurrentValue = null;
        $this->sisa->OldValue = $this->sisa->CurrentValue;
        $this->harga->CurrentValue = null;
        $this->harga->OldValue = $this->harga->CurrentValue;
        $this->tawal->CurrentValue = null;
        $this->tawal->OldValue = $this->tawal->CurrentValue;
        $this->takhir->CurrentValue = null;
        $this->takhir->OldValue = $this->takhir->CurrentValue;
        $this->tanggal_pelaksanaan->CurrentValue = null;
        $this->tanggal_pelaksanaan->OldValue = $this->tanggal_pelaksanaan->CurrentValue;
        $this->gambar->Upload->DbValue = null;
        $this->gambar->OldValue = $this->gambar->Upload->DbValue;
        $this->gambar->CurrentValue = null; // Clear file related field
        $this->kategori->CurrentValue = null;
        $this->kategori->OldValue = $this->kategori->CurrentValue;
        $this->tujuan->CurrentValue = null;
        $this->tujuan->OldValue = $this->tujuan->CurrentValue;
        $this->sub_kategori->CurrentValue = null;
        $this->sub_kategori->OldValue = $this->sub_kategori->CurrentValue;
        $this->topik_bahasan->CurrentValue = null;
        $this->topik_bahasan->OldValue = $this->topik_bahasan->CurrentValue;
        $this->catatan->CurrentValue = null;
        $this->catatan->OldValue = $this->catatan->CurrentValue;
        $this->Link->CurrentValue = null;
        $this->Link->OldValue = $this->Link->CurrentValue;
        $this->Last_Updated->CurrentValue = null;
        $this->Last_Updated->OldValue = $this->Last_Updated->CurrentValue;
        $this->Created_Date->CurrentValue = null;
        $this->Created_Date->OldValue = $this->Created_Date->CurrentValue;
        $this->Activated->CurrentValue = "Y";
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'jenis_pelatihan' first before field var 'x_jenis_pelatihan'
        $val = $CurrentForm->hasValue("jenis_pelatihan") ? $CurrentForm->getValue("jenis_pelatihan") : $CurrentForm->getValue("x_jenis_pelatihan");
        if (!$this->jenis_pelatihan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jenis_pelatihan->Visible = false; // Disable update for API request
            } else {
                $this->jenis_pelatihan->setFormValue($val);
            }
        }

        // Check field name 'judul_pelatihan' first before field var 'x_judul_pelatihan'
        $val = $CurrentForm->hasValue("judul_pelatihan") ? $CurrentForm->getValue("judul_pelatihan") : $CurrentForm->getValue("x_judul_pelatihan");
        if (!$this->judul_pelatihan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->judul_pelatihan->Visible = false; // Disable update for API request
            } else {
                $this->judul_pelatihan->setFormValue($val);
            }
        }

        // Check field name 'jumlah_hari' first before field var 'x_jumlah_hari'
        $val = $CurrentForm->hasValue("jumlah_hari") ? $CurrentForm->getValue("jumlah_hari") : $CurrentForm->getValue("x_jumlah_hari");
        if (!$this->jumlah_hari->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jumlah_hari->Visible = false; // Disable update for API request
            } else {
                $this->jumlah_hari->setFormValue($val);
            }
        }

        // Check field name 'tempat' first before field var 'x_tempat'
        $val = $CurrentForm->hasValue("tempat") ? $CurrentForm->getValue("tempat") : $CurrentForm->getValue("x_tempat");
        if (!$this->tempat->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tempat->Visible = false; // Disable update for API request
            } else {
                $this->tempat->setFormValue($val);
            }
        }

        // Check field name 'jumlah_peserta' first before field var 'x_jumlah_peserta'
        $val = $CurrentForm->hasValue("jumlah_peserta") ? $CurrentForm->getValue("jumlah_peserta") : $CurrentForm->getValue("x_jumlah_peserta");
        if (!$this->jumlah_peserta->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jumlah_peserta->Visible = false; // Disable update for API request
            } else {
                $this->jumlah_peserta->setFormValue($val);
            }
        }

        // Check field name 'sisa' first before field var 'x_sisa'
        $val = $CurrentForm->hasValue("sisa") ? $CurrentForm->getValue("sisa") : $CurrentForm->getValue("x_sisa");
        if (!$this->sisa->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sisa->Visible = false; // Disable update for API request
            } else {
                $this->sisa->setFormValue($val);
            }
        }

        // Check field name 'harga' first before field var 'x_harga'
        $val = $CurrentForm->hasValue("harga") ? $CurrentForm->getValue("harga") : $CurrentForm->getValue("x_harga");
        if (!$this->harga->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->harga->Visible = false; // Disable update for API request
            } else {
                $this->harga->setFormValue($val);
            }
        }

        // Check field name 'tawal' first before field var 'x_tawal'
        $val = $CurrentForm->hasValue("tawal") ? $CurrentForm->getValue("tawal") : $CurrentForm->getValue("x_tawal");
        if (!$this->tawal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tawal->Visible = false; // Disable update for API request
            } else {
                $this->tawal->setFormValue($val);
            }
            $this->tawal->CurrentValue = UnFormatDateTime($this->tawal->CurrentValue, 7);
        }

        // Check field name 'takhir' first before field var 'x_takhir'
        $val = $CurrentForm->hasValue("takhir") ? $CurrentForm->getValue("takhir") : $CurrentForm->getValue("x_takhir");
        if (!$this->takhir->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->takhir->Visible = false; // Disable update for API request
            } else {
                $this->takhir->setFormValue($val);
            }
            $this->takhir->CurrentValue = UnFormatDateTime($this->takhir->CurrentValue, 7);
        }

        // Check field name 'tanggal_pelaksanaan' first before field var 'x_tanggal_pelaksanaan'
        $val = $CurrentForm->hasValue("tanggal_pelaksanaan") ? $CurrentForm->getValue("tanggal_pelaksanaan") : $CurrentForm->getValue("x_tanggal_pelaksanaan");
        if (!$this->tanggal_pelaksanaan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_pelaksanaan->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_pelaksanaan->setFormValue($val);
            }
        }

        // Check field name 'kategori' first before field var 'x_kategori'
        $val = $CurrentForm->hasValue("kategori") ? $CurrentForm->getValue("kategori") : $CurrentForm->getValue("x_kategori");
        if (!$this->kategori->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kategori->Visible = false; // Disable update for API request
            } else {
                $this->kategori->setFormValue($val);
            }
        }

        // Check field name 'tujuan' first before field var 'x_tujuan'
        $val = $CurrentForm->hasValue("tujuan") ? $CurrentForm->getValue("tujuan") : $CurrentForm->getValue("x_tujuan");
        if (!$this->tujuan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tujuan->Visible = false; // Disable update for API request
            } else {
                $this->tujuan->setFormValue($val);
            }
        }

        // Check field name 'sub_kategori' first before field var 'x_sub_kategori'
        $val = $CurrentForm->hasValue("sub_kategori") ? $CurrentForm->getValue("sub_kategori") : $CurrentForm->getValue("x_sub_kategori");
        if (!$this->sub_kategori->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sub_kategori->Visible = false; // Disable update for API request
            } else {
                $this->sub_kategori->setFormValue($val);
            }
        }

        // Check field name 'topik_bahasan' first before field var 'x_topik_bahasan'
        $val = $CurrentForm->hasValue("topik_bahasan") ? $CurrentForm->getValue("topik_bahasan") : $CurrentForm->getValue("x_topik_bahasan");
        if (!$this->topik_bahasan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->topik_bahasan->Visible = false; // Disable update for API request
            } else {
                $this->topik_bahasan->setFormValue($val);
            }
        }

        // Check field name 'catatan' first before field var 'x_catatan'
        $val = $CurrentForm->hasValue("catatan") ? $CurrentForm->getValue("catatan") : $CurrentForm->getValue("x_catatan");
        if (!$this->catatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->catatan->Visible = false; // Disable update for API request
            } else {
                $this->catatan->setFormValue($val);
            }
        }

        // Check field name 'Link' first before field var 'x_Link'
        $val = $CurrentForm->hasValue("Link") ? $CurrentForm->getValue("Link") : $CurrentForm->getValue("x_Link");
        if (!$this->Link->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Link->Visible = false; // Disable update for API request
            } else {
                $this->Link->setFormValue($val);
            }
        }

        // Check field name 'Created_Date' first before field var 'x_Created_Date'
        $val = $CurrentForm->hasValue("Created_Date") ? $CurrentForm->getValue("Created_Date") : $CurrentForm->getValue("x_Created_Date");
        if (!$this->Created_Date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Created_Date->Visible = false; // Disable update for API request
            } else {
                $this->Created_Date->setFormValue($val);
            }
            $this->Created_Date->CurrentValue = UnFormatDateTime($this->Created_Date->CurrentValue, 0);
        }

        // Check field name 'Activated' first before field var 'x_Activated'
        $val = $CurrentForm->hasValue("Activated") ? $CurrentForm->getValue("Activated") : $CurrentForm->getValue("x_Activated");
        if (!$this->Activated->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Activated->Visible = false; // Disable update for API request
            } else {
                $this->Activated->setFormValue($val);
            }
        }

        // Check field name 'pelatihan_id' first before field var 'x_pelatihan_id'
        $val = $CurrentForm->hasValue("pelatihan_id") ? $CurrentForm->getValue("pelatihan_id") : $CurrentForm->getValue("x_pelatihan_id");
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->jenis_pelatihan->CurrentValue = $this->jenis_pelatihan->FormValue;
        $this->judul_pelatihan->CurrentValue = $this->judul_pelatihan->FormValue;
        $this->jumlah_hari->CurrentValue = $this->jumlah_hari->FormValue;
        $this->tempat->CurrentValue = $this->tempat->FormValue;
        $this->jumlah_peserta->CurrentValue = $this->jumlah_peserta->FormValue;
        $this->sisa->CurrentValue = $this->sisa->FormValue;
        $this->harga->CurrentValue = $this->harga->FormValue;
        $this->tawal->CurrentValue = $this->tawal->FormValue;
        $this->tawal->CurrentValue = UnFormatDateTime($this->tawal->CurrentValue, 7);
        $this->takhir->CurrentValue = $this->takhir->FormValue;
        $this->takhir->CurrentValue = UnFormatDateTime($this->takhir->CurrentValue, 7);
        $this->tanggal_pelaksanaan->CurrentValue = $this->tanggal_pelaksanaan->FormValue;
        $this->kategori->CurrentValue = $this->kategori->FormValue;
        $this->tujuan->CurrentValue = $this->tujuan->FormValue;
        $this->sub_kategori->CurrentValue = $this->sub_kategori->FormValue;
        $this->topik_bahasan->CurrentValue = $this->topik_bahasan->FormValue;
        $this->catatan->CurrentValue = $this->catatan->FormValue;
        $this->Link->CurrentValue = $this->Link->FormValue;
        $this->Created_Date->CurrentValue = $this->Created_Date->FormValue;
        $this->Created_Date->CurrentValue = UnFormatDateTime($this->Created_Date->CurrentValue, 0);
        $this->Activated->CurrentValue = $this->Activated->FormValue;
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
        $this->loadDefaultValues();
        $row = [];
        $row['pelatihan_id'] = $this->pelatihan_id->CurrentValue;
        $row['jenis_pelatihan'] = $this->jenis_pelatihan->CurrentValue;
        $row['judul_pelatihan'] = $this->judul_pelatihan->CurrentValue;
        $row['jumlah_hari'] = $this->jumlah_hari->CurrentValue;
        $row['tempat'] = $this->tempat->CurrentValue;
        $row['jumlah_peserta'] = $this->jumlah_peserta->CurrentValue;
        $row['sisa'] = $this->sisa->CurrentValue;
        $row['harga'] = $this->harga->CurrentValue;
        $row['tawal'] = $this->tawal->CurrentValue;
        $row['takhir'] = $this->takhir->CurrentValue;
        $row['tanggal_pelaksanaan'] = $this->tanggal_pelaksanaan->CurrentValue;
        $row['gambar'] = $this->gambar->Upload->DbValue;
        $row['kategori'] = $this->kategori->CurrentValue;
        $row['tujuan'] = $this->tujuan->CurrentValue;
        $row['sub_kategori'] = $this->sub_kategori->CurrentValue;
        $row['topik_bahasan'] = $this->topik_bahasan->CurrentValue;
        $row['catatan'] = $this->catatan->CurrentValue;
        $row['Link'] = $this->Link->CurrentValue;
        $row['Last_Updated'] = $this->Last_Updated->CurrentValue;
        $row['Created_Date'] = $this->Created_Date->CurrentValue;
        $row['Activated'] = $this->Activated->CurrentValue;
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

            // Created_Date
            $this->Created_Date->LinkCustomAttributes = "";
            $this->Created_Date->HrefValue = "";
            $this->Created_Date->TooltipValue = "";

            // Activated
            $this->Activated->LinkCustomAttributes = "";
            $this->Activated->HrefValue = "";
            $this->Activated->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // jenis_pelatihan
            $this->jenis_pelatihan->EditAttrs["class"] = "form-control";
            $this->jenis_pelatihan->EditCustomAttributes = "";
            $this->jenis_pelatihan->EditValue = $this->jenis_pelatihan->options(true);
            $this->jenis_pelatihan->PlaceHolder = RemoveHtml($this->jenis_pelatihan->caption());

            // judul_pelatihan
            $this->judul_pelatihan->EditAttrs["class"] = "form-control";
            $this->judul_pelatihan->EditCustomAttributes = "";
            if (!$this->judul_pelatihan->Raw) {
                $this->judul_pelatihan->CurrentValue = HtmlDecode($this->judul_pelatihan->CurrentValue);
            }
            $this->judul_pelatihan->EditValue = HtmlEncode($this->judul_pelatihan->CurrentValue);
            $this->judul_pelatihan->PlaceHolder = RemoveHtml($this->judul_pelatihan->caption());

            // jumlah_hari
            $this->jumlah_hari->EditAttrs["class"] = "form-control";
            $this->jumlah_hari->EditCustomAttributes = "";
            if (!$this->jumlah_hari->Raw) {
                $this->jumlah_hari->CurrentValue = HtmlDecode($this->jumlah_hari->CurrentValue);
            }
            $this->jumlah_hari->EditValue = HtmlEncode($this->jumlah_hari->CurrentValue);
            $this->jumlah_hari->PlaceHolder = RemoveHtml($this->jumlah_hari->caption());

            // tempat
            $this->tempat->EditAttrs["class"] = "form-control";
            $this->tempat->EditCustomAttributes = "";
            if (!$this->tempat->Raw) {
                $this->tempat->CurrentValue = HtmlDecode($this->tempat->CurrentValue);
            }
            $this->tempat->EditValue = HtmlEncode($this->tempat->CurrentValue);
            $this->tempat->PlaceHolder = RemoveHtml($this->tempat->caption());

            // jumlah_peserta
            $this->jumlah_peserta->EditAttrs["class"] = "form-control";
            $this->jumlah_peserta->EditCustomAttributes = "";
            $this->jumlah_peserta->EditValue = HtmlEncode($this->jumlah_peserta->CurrentValue);
            $this->jumlah_peserta->PlaceHolder = RemoveHtml($this->jumlah_peserta->caption());

            // sisa
            $this->sisa->EditAttrs["class"] = "form-control";
            $this->sisa->EditCustomAttributes = "";
            $this->sisa->EditValue = HtmlEncode($this->sisa->CurrentValue);
            $this->sisa->PlaceHolder = RemoveHtml($this->sisa->caption());

            // harga
            $this->harga->EditAttrs["class"] = "form-control";
            $this->harga->EditCustomAttributes = "";
            $this->harga->EditValue = HtmlEncode($this->harga->CurrentValue);
            $this->harga->PlaceHolder = RemoveHtml($this->harga->caption());
            if (strval($this->harga->EditValue) != "" && is_numeric($this->harga->EditValue)) {
                $this->harga->EditValue = FormatNumber($this->harga->EditValue, -2, -2, -2, -2);
            }

            // tawal
            $this->tawal->EditAttrs["class"] = "form-control";
            $this->tawal->EditCustomAttributes = "";
            $this->tawal->EditValue = HtmlEncode(FormatDateTime($this->tawal->CurrentValue, 7));
            $this->tawal->PlaceHolder = RemoveHtml($this->tawal->caption());

            // takhir
            $this->takhir->EditAttrs["class"] = "form-control";
            $this->takhir->EditCustomAttributes = "";
            $this->takhir->EditValue = HtmlEncode(FormatDateTime($this->takhir->CurrentValue, 7));
            $this->takhir->PlaceHolder = RemoveHtml($this->takhir->caption());

            // tanggal_pelaksanaan
            $this->tanggal_pelaksanaan->EditAttrs["class"] = "form-control";
            $this->tanggal_pelaksanaan->EditCustomAttributes = "";
            if (!$this->tanggal_pelaksanaan->Raw) {
                $this->tanggal_pelaksanaan->CurrentValue = HtmlDecode($this->tanggal_pelaksanaan->CurrentValue);
            }
            $this->tanggal_pelaksanaan->EditValue = HtmlEncode($this->tanggal_pelaksanaan->CurrentValue);
            $this->tanggal_pelaksanaan->PlaceHolder = RemoveHtml($this->tanggal_pelaksanaan->caption());

            // gambar
            $this->gambar->EditAttrs["class"] = "form-control";
            $this->gambar->EditCustomAttributes = "";
            if (!EmptyValue($this->gambar->Upload->DbValue)) {
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

            // kategori
            $this->kategori->EditAttrs["class"] = "form-control";
            $this->kategori->EditCustomAttributes = "";
            if (!$this->kategori->Raw) {
                $this->kategori->CurrentValue = HtmlDecode($this->kategori->CurrentValue);
            }
            $this->kategori->EditValue = HtmlEncode($this->kategori->CurrentValue);
            $this->kategori->PlaceHolder = RemoveHtml($this->kategori->caption());

            // tujuan
            $this->tujuan->EditAttrs["class"] = "form-control";
            $this->tujuan->EditCustomAttributes = "";
            $this->tujuan->EditValue = HtmlEncode($this->tujuan->CurrentValue);
            $this->tujuan->PlaceHolder = RemoveHtml($this->tujuan->caption());

            // sub_kategori
            $this->sub_kategori->EditAttrs["class"] = "form-control";
            $this->sub_kategori->EditCustomAttributes = "";
            if (!$this->sub_kategori->Raw) {
                $this->sub_kategori->CurrentValue = HtmlDecode($this->sub_kategori->CurrentValue);
            }
            $this->sub_kategori->EditValue = HtmlEncode($this->sub_kategori->CurrentValue);
            $this->sub_kategori->PlaceHolder = RemoveHtml($this->sub_kategori->caption());

            // topik_bahasan
            $this->topik_bahasan->EditAttrs["class"] = "form-control";
            $this->topik_bahasan->EditCustomAttributes = "";
            $this->topik_bahasan->EditValue = HtmlEncode($this->topik_bahasan->CurrentValue);
            $this->topik_bahasan->PlaceHolder = RemoveHtml($this->topik_bahasan->caption());

            // catatan
            $this->catatan->EditAttrs["class"] = "form-control";
            $this->catatan->EditCustomAttributes = "";
            $this->catatan->EditValue = HtmlEncode($this->catatan->CurrentValue);
            $this->catatan->PlaceHolder = RemoveHtml($this->catatan->caption());

            // Link
            $this->Link->EditAttrs["class"] = "form-control";
            $this->Link->EditCustomAttributes = "";
            $this->Link->EditValue = HtmlEncode($this->Link->CurrentValue);
            $this->Link->PlaceHolder = RemoveHtml($this->Link->caption());

            // Created_Date

            // Activated
            $this->Activated->EditCustomAttributes = "";
            $this->Activated->EditValue = $this->Activated->options(false);
            $this->Activated->PlaceHolder = RemoveHtml($this->Activated->caption());

            // Add refer script

            // jenis_pelatihan
            $this->jenis_pelatihan->LinkCustomAttributes = "";
            $this->jenis_pelatihan->HrefValue = "";

            // judul_pelatihan
            $this->judul_pelatihan->LinkCustomAttributes = "";
            $this->judul_pelatihan->HrefValue = "";

            // jumlah_hari
            $this->jumlah_hari->LinkCustomAttributes = "";
            $this->jumlah_hari->HrefValue = "";

            // tempat
            $this->tempat->LinkCustomAttributes = "";
            $this->tempat->HrefValue = "";

            // jumlah_peserta
            $this->jumlah_peserta->LinkCustomAttributes = "";
            $this->jumlah_peserta->HrefValue = "";

            // sisa
            $this->sisa->LinkCustomAttributes = "";
            $this->sisa->HrefValue = "";

            // harga
            $this->harga->LinkCustomAttributes = "";
            $this->harga->HrefValue = "";

            // tawal
            $this->tawal->LinkCustomAttributes = "";
            $this->tawal->HrefValue = "";

            // takhir
            $this->takhir->LinkCustomAttributes = "";
            $this->takhir->HrefValue = "";

            // tanggal_pelaksanaan
            $this->tanggal_pelaksanaan->LinkCustomAttributes = "";
            $this->tanggal_pelaksanaan->HrefValue = "";

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

            // kategori
            $this->kategori->LinkCustomAttributes = "";
            $this->kategori->HrefValue = "";

            // tujuan
            $this->tujuan->LinkCustomAttributes = "";
            $this->tujuan->HrefValue = "";

            // sub_kategori
            $this->sub_kategori->LinkCustomAttributes = "";
            $this->sub_kategori->HrefValue = "";

            // topik_bahasan
            $this->topik_bahasan->LinkCustomAttributes = "";
            $this->topik_bahasan->HrefValue = "";

            // catatan
            $this->catatan->LinkCustomAttributes = "";
            $this->catatan->HrefValue = "";

            // Link
            $this->Link->LinkCustomAttributes = "";
            $this->Link->HrefValue = "";

            // Created_Date
            $this->Created_Date->LinkCustomAttributes = "";
            $this->Created_Date->HrefValue = "";

            // Activated
            $this->Activated->LinkCustomAttributes = "";
            $this->Activated->HrefValue = "";
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
        if ($this->jenis_pelatihan->Required) {
            if (!$this->jenis_pelatihan->IsDetailKey && EmptyValue($this->jenis_pelatihan->FormValue)) {
                $this->jenis_pelatihan->addErrorMessage(str_replace("%s", $this->jenis_pelatihan->caption(), $this->jenis_pelatihan->RequiredErrorMessage));
            }
        }
        if ($this->judul_pelatihan->Required) {
            if (!$this->judul_pelatihan->IsDetailKey && EmptyValue($this->judul_pelatihan->FormValue)) {
                $this->judul_pelatihan->addErrorMessage(str_replace("%s", $this->judul_pelatihan->caption(), $this->judul_pelatihan->RequiredErrorMessage));
            }
        }
        if ($this->jumlah_hari->Required) {
            if (!$this->jumlah_hari->IsDetailKey && EmptyValue($this->jumlah_hari->FormValue)) {
                $this->jumlah_hari->addErrorMessage(str_replace("%s", $this->jumlah_hari->caption(), $this->jumlah_hari->RequiredErrorMessage));
            }
        }
        if ($this->tempat->Required) {
            if (!$this->tempat->IsDetailKey && EmptyValue($this->tempat->FormValue)) {
                $this->tempat->addErrorMessage(str_replace("%s", $this->tempat->caption(), $this->tempat->RequiredErrorMessage));
            }
        }
        if ($this->jumlah_peserta->Required) {
            if (!$this->jumlah_peserta->IsDetailKey && EmptyValue($this->jumlah_peserta->FormValue)) {
                $this->jumlah_peserta->addErrorMessage(str_replace("%s", $this->jumlah_peserta->caption(), $this->jumlah_peserta->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->jumlah_peserta->FormValue)) {
            $this->jumlah_peserta->addErrorMessage($this->jumlah_peserta->getErrorMessage(false));
        }
        if ($this->sisa->Required) {
            if (!$this->sisa->IsDetailKey && EmptyValue($this->sisa->FormValue)) {
                $this->sisa->addErrorMessage(str_replace("%s", $this->sisa->caption(), $this->sisa->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->sisa->FormValue)) {
            $this->sisa->addErrorMessage($this->sisa->getErrorMessage(false));
        }
        if ($this->harga->Required) {
            if (!$this->harga->IsDetailKey && EmptyValue($this->harga->FormValue)) {
                $this->harga->addErrorMessage(str_replace("%s", $this->harga->caption(), $this->harga->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->harga->FormValue)) {
            $this->harga->addErrorMessage($this->harga->getErrorMessage(false));
        }
        if ($this->tawal->Required) {
            if (!$this->tawal->IsDetailKey && EmptyValue($this->tawal->FormValue)) {
                $this->tawal->addErrorMessage(str_replace("%s", $this->tawal->caption(), $this->tawal->RequiredErrorMessage));
            }
        }
        if (!CheckEuroDate($this->tawal->FormValue)) {
            $this->tawal->addErrorMessage($this->tawal->getErrorMessage(false));
        }
        if ($this->takhir->Required) {
            if (!$this->takhir->IsDetailKey && EmptyValue($this->takhir->FormValue)) {
                $this->takhir->addErrorMessage(str_replace("%s", $this->takhir->caption(), $this->takhir->RequiredErrorMessage));
            }
        }
        if (!CheckEuroDate($this->takhir->FormValue)) {
            $this->takhir->addErrorMessage($this->takhir->getErrorMessage(false));
        }
        if ($this->tanggal_pelaksanaan->Required) {
            if (!$this->tanggal_pelaksanaan->IsDetailKey && EmptyValue($this->tanggal_pelaksanaan->FormValue)) {
                $this->tanggal_pelaksanaan->addErrorMessage(str_replace("%s", $this->tanggal_pelaksanaan->caption(), $this->tanggal_pelaksanaan->RequiredErrorMessage));
            }
        }
        if ($this->gambar->Required) {
            if ($this->gambar->Upload->FileName == "" && !$this->gambar->Upload->KeepFile) {
                $this->gambar->addErrorMessage(str_replace("%s", $this->gambar->caption(), $this->gambar->RequiredErrorMessage));
            }
        }
        if ($this->kategori->Required) {
            if (!$this->kategori->IsDetailKey && EmptyValue($this->kategori->FormValue)) {
                $this->kategori->addErrorMessage(str_replace("%s", $this->kategori->caption(), $this->kategori->RequiredErrorMessage));
            }
        }
        if ($this->tujuan->Required) {
            if (!$this->tujuan->IsDetailKey && EmptyValue($this->tujuan->FormValue)) {
                $this->tujuan->addErrorMessage(str_replace("%s", $this->tujuan->caption(), $this->tujuan->RequiredErrorMessage));
            }
        }
        if ($this->sub_kategori->Required) {
            if (!$this->sub_kategori->IsDetailKey && EmptyValue($this->sub_kategori->FormValue)) {
                $this->sub_kategori->addErrorMessage(str_replace("%s", $this->sub_kategori->caption(), $this->sub_kategori->RequiredErrorMessage));
            }
        }
        if ($this->topik_bahasan->Required) {
            if (!$this->topik_bahasan->IsDetailKey && EmptyValue($this->topik_bahasan->FormValue)) {
                $this->topik_bahasan->addErrorMessage(str_replace("%s", $this->topik_bahasan->caption(), $this->topik_bahasan->RequiredErrorMessage));
            }
        }
        if ($this->catatan->Required) {
            if (!$this->catatan->IsDetailKey && EmptyValue($this->catatan->FormValue)) {
                $this->catatan->addErrorMessage(str_replace("%s", $this->catatan->caption(), $this->catatan->RequiredErrorMessage));
            }
        }
        if ($this->Link->Required) {
            if (!$this->Link->IsDetailKey && EmptyValue($this->Link->FormValue)) {
                $this->Link->addErrorMessage(str_replace("%s", $this->Link->caption(), $this->Link->RequiredErrorMessage));
            }
        }
        if ($this->Created_Date->Required) {
            if (!$this->Created_Date->IsDetailKey && EmptyValue($this->Created_Date->FormValue)) {
                $this->Created_Date->addErrorMessage(str_replace("%s", $this->Created_Date->caption(), $this->Created_Date->RequiredErrorMessage));
            }
        }
        if ($this->Activated->Required) {
            if ($this->Activated->FormValue == "") {
                $this->Activated->addErrorMessage(str_replace("%s", $this->Activated->caption(), $this->Activated->RequiredErrorMessage));
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
        }
        $rsnew = [];

        // jenis_pelatihan
        $this->jenis_pelatihan->setDbValueDef($rsnew, $this->jenis_pelatihan->CurrentValue, "", false);

        // judul_pelatihan
        $this->judul_pelatihan->setDbValueDef($rsnew, $this->judul_pelatihan->CurrentValue, "", false);

        // jumlah_hari
        $this->jumlah_hari->setDbValueDef($rsnew, $this->jumlah_hari->CurrentValue, "", false);

        // tempat
        $this->tempat->setDbValueDef($rsnew, $this->tempat->CurrentValue, "", false);

        // jumlah_peserta
        $this->jumlah_peserta->setDbValueDef($rsnew, $this->jumlah_peserta->CurrentValue, 0, false);

        // sisa
        $this->sisa->setDbValueDef($rsnew, $this->sisa->CurrentValue, 0, false);

        // harga
        $this->harga->setDbValueDef($rsnew, $this->harga->CurrentValue, 0, false);

        // tawal
        $this->tawal->setDbValueDef($rsnew, UnFormatDateTime($this->tawal->CurrentValue, 7), null, false);

        // takhir
        $this->takhir->setDbValueDef($rsnew, UnFormatDateTime($this->takhir->CurrentValue, 7), null, false);

        // tanggal_pelaksanaan
        $this->tanggal_pelaksanaan->setDbValueDef($rsnew, $this->tanggal_pelaksanaan->CurrentValue, "", false);

        // gambar
        if ($this->gambar->Visible && !$this->gambar->Upload->KeepFile) {
            $this->gambar->Upload->DbValue = ""; // No need to delete old file
            if ($this->gambar->Upload->FileName == "") {
                $rsnew['gambar'] = null;
            } else {
                $rsnew['gambar'] = $this->gambar->Upload->FileName;
            }
            $this->gambar->ImageWidth = 960; // Resize width
            $this->gambar->ImageHeight = 540; // Resize height
        }

        // kategori
        $this->kategori->setDbValueDef($rsnew, $this->kategori->CurrentValue, "", false);

        // tujuan
        $this->tujuan->setDbValueDef($rsnew, $this->tujuan->CurrentValue, null, false);

        // sub_kategori
        $this->sub_kategori->setDbValueDef($rsnew, $this->sub_kategori->CurrentValue, "", false);

        // topik_bahasan
        $this->topik_bahasan->setDbValueDef($rsnew, $this->topik_bahasan->CurrentValue, "", false);

        // catatan
        $this->catatan->setDbValueDef($rsnew, $this->catatan->CurrentValue, null, false);

        // Link
        $this->Link->setDbValueDef($rsnew, $this->Link->CurrentValue, null, false);

        // Created_Date
        $this->Created_Date->CurrentValue = CurrentDateTime();
        $this->Created_Date->setDbValueDef($rsnew, $this->Created_Date->CurrentValue, CurrentDate());

        // Activated
        $tmpBool = $this->Activated->CurrentValue;
        if ($tmpBool != "Y" && $tmpBool != "N") {
            $tmpBool = !empty($tmpBool) ? "Y" : "N";
        }
        $this->Activated->setDbValueDef($rsnew, $tmpBool, null, strval($this->Activated->CurrentValue) == "");
        if ($this->gambar->Visible && !$this->gambar->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->gambar->Upload->DbValue) ? [] : [$this->gambar->htmlDecode($this->gambar->Upload->DbValue)];
            if (!EmptyValue($this->gambar->Upload->FileName)) {
                $newFiles = [$this->gambar->Upload->FileName];
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
                $this->gambar->setDbValueDef($rsnew, $this->gambar->Upload->FileName, "", false);
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
                    $oldFiles = EmptyValue($this->gambar->Upload->DbValue) ? [] : [$this->gambar->htmlDecode($this->gambar->Upload->DbValue)];
                    if (!EmptyValue($this->gambar->Upload->FileName)) {
                        $newFiles = [$this->gambar->Upload->FileName];
                        $newFiles2 = [$this->gambar->htmlDecode($rsnew['gambar'])];
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("wpelatihanlist"), "", $this->TableVar, true);
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
