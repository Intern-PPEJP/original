<?php

namespace PHPMaker2021\ppejp_web;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for w_testimoni
 */
class WTestimoni extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Export
    public $ExportDoc;

    // Fields
    public $testimoni_id;
    public $nama;
    public $gambar;
    public $testimoni;
    public $link_testimoni;
    public $show;
    public $created_at;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'w_testimoni';
        $this->TableName = 'w_testimoni';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`w_testimoni`";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // testimoni_id
        $this->testimoni_id = new DbField('w_testimoni', 'w_testimoni', 'x_testimoni_id', 'testimoni_id', '`testimoni_id`', '`testimoni_id`', 3, 11, -1, false, '`testimoni_id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->testimoni_id->IsAutoIncrement = true; // Autoincrement field
        $this->testimoni_id->IsPrimaryKey = true; // Primary key field
        $this->testimoni_id->Sortable = true; // Allow sort
        $this->testimoni_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->testimoni_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->testimoni_id->Param, "CustomMsg");
        $this->Fields['testimoni_id'] = &$this->testimoni_id;

        // nama
        $this->nama = new DbField('w_testimoni', 'w_testimoni', 'x_nama', 'nama', '`nama`', '`nama`', 200, 100, -1, false, '`nama`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama->Sortable = true; // Allow sort
        $this->nama->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama->Param, "CustomMsg");
        $this->Fields['nama'] = &$this->nama;

        // gambar
        $this->gambar = new DbField('w_testimoni', 'w_testimoni', 'x_gambar', 'gambar', '`gambar`', '`gambar`', 200, 200, -1, true, '`gambar`', false, false, false, 'IMAGE', 'FILE');
        $this->gambar->Nullable = false; // NOT NULL field
        $this->gambar->Required = true; // Required field
        $this->gambar->Sortable = true; // Allow sort
        $this->gambar->UploadAllowedFileExt = "jpg,jpeg,bmp,png";
        $this->gambar->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->gambar->Param, "CustomMsg");
        $this->Fields['gambar'] = &$this->gambar;

        // testimoni
        $this->testimoni = new DbField('w_testimoni', 'w_testimoni', 'x_testimoni', 'testimoni', '`testimoni`', '`testimoni`', 200, 200, -1, false, '`testimoni`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->testimoni->Nullable = false; // NOT NULL field
        $this->testimoni->Required = true; // Required field
        $this->testimoni->Sortable = true; // Allow sort
        $this->testimoni->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->testimoni->Param, "CustomMsg");
        $this->Fields['testimoni'] = &$this->testimoni;

        // link_testimoni
        $this->link_testimoni = new DbField('w_testimoni', 'w_testimoni', 'x_link_testimoni', 'link_testimoni', '`link_testimoni`', '`link_testimoni`', 201, 65535, -1, false, '`link_testimoni`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->link_testimoni->Sortable = true; // Allow sort
        $this->link_testimoni->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->link_testimoni->Param, "CustomMsg");
        $this->Fields['link_testimoni'] = &$this->link_testimoni;

        // show
        $this->show = new DbField('w_testimoni', 'w_testimoni', 'x_show', 'show', '`show`', '`show`', 202, 1, -1, false, '`show`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->show->Nullable = false; // NOT NULL field
        $this->show->Sortable = true; // Allow sort
        $this->show->DataType = DATATYPE_BOOLEAN;
        $this->show->TrueValue = "Y";
        $this->show->FalseValue = "N";
        $this->show->Lookup = new Lookup('show', 'w_testimoni', false, '', ["","","",""], [], [], [], [], [], [], '', '');
        $this->show->OptionCount = 2;
        $this->show->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->show->Param, "CustomMsg");
        $this->Fields['show'] = &$this->show;

        // created_at
        $this->created_at = new DbField('w_testimoni', 'w_testimoni', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Nullable = false; // NOT NULL field
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        } else {
            $fld->setSort("");
        }
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`w_testimoni`";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : $this->DefaultSort;
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter)
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof \Doctrine\DBAL\Query\QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $rs = $conn->executeQuery($sqlwrk);
        $cnt = $rs->fetchColumn();
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    protected function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        $success = $this->insertSql($rs)->execute();
        if ($success) {
            // Get insert id if necessary
            $this->testimoni_id->setDbValue($conn->lastInsertId());
            $rs['testimoni_id'] = $this->testimoni_id->DbValue;
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('testimoni_id', $rs)) {
                AddFilter($where, QuotedName('testimoni_id', $this->Dbid) . '=' . QuotedValue($rs['testimoni_id'], $this->testimoni_id->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->testimoni_id->DbValue = $row['testimoni_id'];
        $this->nama->DbValue = $row['nama'];
        $this->gambar->Upload->DbValue = $row['gambar'];
        $this->testimoni->DbValue = $row['testimoni'];
        $this->link_testimoni->DbValue = $row['link_testimoni'];
        $this->show->DbValue = $row['show'];
        $this->created_at->DbValue = $row['created_at'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $this->gambar->OldUploadPath = "images/testimoni/";
        $oldFiles = EmptyValue($row['gambar']) ? [] : [$row['gambar']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->gambar->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->gambar->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`testimoni_id` = @testimoni_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->testimoni_id->CurrentValue : $this->testimoni_id->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->testimoni_id->CurrentValue = $keys[0];
            } else {
                $this->testimoni_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('testimoni_id', $row) ? $row['testimoni_id'] : null;
        } else {
            $val = $this->testimoni_id->OldValue !== null ? $this->testimoni_id->OldValue : $this->testimoni_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@testimoni_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("wtestimonilist");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "wtestimoniview") {
            return $Language->phrase("View");
        } elseif ($pageName == "wtestimoniedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "wtestimoniadd") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "WTestimoniView";
            case Config("API_ADD_ACTION"):
                return "WTestimoniAdd";
            case Config("API_EDIT_ACTION"):
                return "WTestimoniEdit";
            case Config("API_DELETE_ACTION"):
                return "WTestimoniDelete";
            case Config("API_LIST_ACTION"):
                return "WTestimoniList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "wtestimonilist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("wtestimoniview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("wtestimoniview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "wtestimoniadd?" . $this->getUrlParm($parm);
        } else {
            $url = "wtestimoniadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("wtestimoniedit", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("wtestimoniadd", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("wtestimonidelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "testimoni_id:" . JsonEncode($this->testimoni_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->testimoni_id->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->testimoni_id->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderSort($fld)
    {
        $classId = $fld->TableVar . "_" . $fld->Param;
        $scriptId = str_replace("%id%", $classId, "tpc_%id%");
        $scriptStart = $this->UseCustomTemplate ? "<template id=\"" . $scriptId . "\">" : "";
        $scriptEnd = $this->UseCustomTemplate ? "</template>" : "";
        $jsSort = " class=\"ew-pointer\" onclick=\"ew.sort(event, '" . $this->sortUrl($fld) . "', 1);\"";
        if ($this->sortUrl($fld) == "") {
            $html = <<<NOSORTHTML
{$scriptStart}<div class="ew-table-header-caption">{$fld->caption()}</div>{$scriptEnd}
NOSORTHTML;
        } else {
            if ($fld->getSort() == "ASC") {
                $sortIcon = '<i class="fas fa-sort-up"></i>';
            } elseif ($fld->getSort() == "DESC") {
                $sortIcon = '<i class="fas fa-sort-down"></i>';
            } else {
                $sortIcon = '';
            }
            $html = <<<SORTHTML
{$scriptStart}<div{$jsSort}><div class="ew-table-header-btn"><span class="ew-table-header-caption">{$fld->caption()}</span><span class="ew-table-header-sort">{$sortIcon}</span></div></div>{$scriptEnd}
SORTHTML;
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("testimoni_id") ?? Route("testimoni_id")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->testimoni_id->CurrentValue = $key;
            } else {
                $this->testimoni_id->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function &loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        $stmt = $conn->executeQuery($sql);
        return $stmt;
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->testimoni_id->setDbValue($row['testimoni_id']);
        $this->nama->setDbValue($row['nama']);
        $this->gambar->Upload->DbValue = $row['gambar'];
        $this->gambar->setDbValue($this->gambar->Upload->DbValue);
        $this->testimoni->setDbValue($row['testimoni']);
        $this->link_testimoni->setDbValue($row['link_testimoni']);
        $this->show->setDbValue($row['show']);
        $this->created_at->setDbValue($row['created_at']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // testimoni_id

        // nama

        // gambar

        // testimoni

        // link_testimoni

        // show

        // created_at

        // testimoni_id
        $this->testimoni_id->ViewValue = $this->testimoni_id->CurrentValue;
        $this->testimoni_id->ViewCustomAttributes = "";

        // nama
        $this->nama->ViewValue = $this->nama->CurrentValue;
        $this->nama->ViewCustomAttributes = "";

        // gambar
        $this->gambar->UploadPath = "images/testimoni/";
        if (!EmptyValue($this->gambar->Upload->DbValue)) {
            $this->gambar->ImageWidth = 100;
            $this->gambar->ImageHeight = 100;
            $this->gambar->ImageAlt = $this->gambar->alt();
            $this->gambar->ViewValue = $this->gambar->Upload->DbValue;
        } else {
            $this->gambar->ViewValue = "";
        }
        $this->gambar->ViewCustomAttributes = "";

        // testimoni
        $this->testimoni->ViewValue = $this->testimoni->CurrentValue;
        $this->testimoni->ViewCustomAttributes = "";

        // link_testimoni
        $this->link_testimoni->ViewValue = $this->link_testimoni->CurrentValue;
        $this->link_testimoni->ViewCustomAttributes = "";

        // show
        if (ConvertToBool($this->show->CurrentValue)) {
            $this->show->ViewValue = $this->show->tagCaption(1) != "" ? $this->show->tagCaption(1) : "Ya";
        } else {
            $this->show->ViewValue = $this->show->tagCaption(2) != "" ? $this->show->tagCaption(2) : "Tidak";
        }
        $this->show->ViewCustomAttributes = "";

        // created_at
        $this->created_at->ViewValue = $this->created_at->CurrentValue;
        $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
        $this->created_at->ViewCustomAttributes = "";

        // testimoni_id
        $this->testimoni_id->LinkCustomAttributes = "";
        $this->testimoni_id->HrefValue = "";
        $this->testimoni_id->TooltipValue = "";

        // nama
        $this->nama->LinkCustomAttributes = "";
        $this->nama->HrefValue = "";
        $this->nama->TooltipValue = "";

        // gambar
        $this->gambar->LinkCustomAttributes = "";
        $this->gambar->UploadPath = "images/testimoni/";
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
            $this->gambar->LinkAttrs["data-rel"] = "w_testimoni_x_gambar";
            $this->gambar->LinkAttrs->appendClass("ew-lightbox");
        }

        // testimoni
        $this->testimoni->LinkCustomAttributes = "";
        if (!EmptyValue($this->link_testimoni->CurrentValue)) {
            $this->testimoni->HrefValue = (!empty($this->link_testimoni->ViewValue) && !is_array($this->link_testimoni->ViewValue) ? RemoveHtml($this->link_testimoni->ViewValue) : $this->link_testimoni->CurrentValue); // Add prefix/suffix
            $this->testimoni->LinkAttrs["target"] = ""; // Add target
            if ($this->isExport()) {
                $this->testimoni->HrefValue = FullUrl($this->testimoni->HrefValue, "href");
            }
        } else {
            $this->testimoni->HrefValue = "";
        }
        $this->testimoni->TooltipValue = "";

        // link_testimoni
        $this->link_testimoni->LinkCustomAttributes = "";
        $this->link_testimoni->HrefValue = "";
        $this->link_testimoni->TooltipValue = "";

        // show
        $this->show->LinkCustomAttributes = "";
        $this->show->HrefValue = "";
        $this->show->TooltipValue = "";

        // created_at
        $this->created_at->LinkCustomAttributes = "";
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // testimoni_id
        $this->testimoni_id->EditAttrs["class"] = "form-control";
        $this->testimoni_id->EditCustomAttributes = "";
        $this->testimoni_id->EditValue = $this->testimoni_id->CurrentValue;
        $this->testimoni_id->ViewCustomAttributes = "";

        // nama
        $this->nama->EditAttrs["class"] = "form-control";
        $this->nama->EditCustomAttributes = "";
        if (!$this->nama->Raw) {
            $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
        }
        $this->nama->EditValue = $this->nama->CurrentValue;
        $this->nama->PlaceHolder = RemoveHtml($this->nama->caption());

        // gambar
        $this->gambar->EditAttrs["class"] = "form-control";
        $this->gambar->EditCustomAttributes = "";
        $this->gambar->UploadPath = "images/testimoni/";
        if (!EmptyValue($this->gambar->Upload->DbValue)) {
            $this->gambar->ImageWidth = 100;
            $this->gambar->ImageHeight = 100;
            $this->gambar->ImageAlt = $this->gambar->alt();
            $this->gambar->EditValue = $this->gambar->Upload->DbValue;
        } else {
            $this->gambar->EditValue = "";
        }
        if (!EmptyValue($this->gambar->CurrentValue)) {
            $this->gambar->Upload->FileName = $this->gambar->CurrentValue;
        }

        // testimoni
        $this->testimoni->EditAttrs["class"] = "form-control";
        $this->testimoni->EditCustomAttributes = "";
        if (!$this->testimoni->Raw) {
            $this->testimoni->CurrentValue = HtmlDecode($this->testimoni->CurrentValue);
        }
        $this->testimoni->EditValue = $this->testimoni->CurrentValue;
        $this->testimoni->PlaceHolder = RemoveHtml($this->testimoni->caption());

        // link_testimoni
        $this->link_testimoni->EditAttrs["class"] = "form-control";
        $this->link_testimoni->EditCustomAttributes = "";
        $this->link_testimoni->EditValue = $this->link_testimoni->CurrentValue;
        $this->link_testimoni->PlaceHolder = RemoveHtml($this->link_testimoni->caption());

        // show
        $this->show->EditCustomAttributes = "";
        $this->show->EditValue = $this->show->options(false);
        $this->show->PlaceHolder = RemoveHtml($this->show->caption());

        // created_at

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->testimoni_id);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->gambar);
                    $doc->exportCaption($this->testimoni);
                    $doc->exportCaption($this->link_testimoni);
                    $doc->exportCaption($this->show);
                    $doc->exportCaption($this->created_at);
                } else {
                    $doc->exportCaption($this->testimoni_id);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->gambar);
                    $doc->exportCaption($this->testimoni);
                    $doc->exportCaption($this->show);
                    $doc->exportCaption($this->created_at);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->testimoni_id);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->gambar);
                        $doc->exportField($this->testimoni);
                        $doc->exportField($this->link_testimoni);
                        $doc->exportField($this->show);
                        $doc->exportField($this->created_at);
                    } else {
                        $doc->exportField($this->testimoni_id);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->gambar);
                        $doc->exportField($this->testimoni);
                        $doc->exportField($this->show);
                        $doc->exportField($this->created_at);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        $width = ($width > 0) ? $width : Config("THUMBNAIL_DEFAULT_WIDTH");
        $height = ($height > 0) ? $height : Config("THUMBNAIL_DEFAULT_HEIGHT");

        // Set up field name / file name field / file type field
        $fldName = "";
        $fileNameFld = "";
        $fileTypeFld = "";
        if ($fldparm == 'gambar') {
            $fldName = "gambar";
            $fileNameFld = "gambar";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->testimoni_id->CurrentValue = $ar[0];
        } else {
            return false; // Incorrect key
        }

        // Set up filter (WHERE Clause)
        $filter = $this->getRecordFilter();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $dbtype = GetConnectionType($this->Dbid);
        if ($row = $conn->fetchAssoc($sql)) {
            $val = $row[$fldName];
            if (!EmptyValue($val)) {
                $fld = $this->Fields[$fldName];

                // Binary data
                if ($fld->DataType == DATATYPE_BLOB) {
                    if ($dbtype != "MYSQL") {
                        if (is_resource($val) && get_resource_type($val) == "stream") { // Byte array
                            $val = stream_get_contents($val);
                        }
                    }
                    if ($resize) {
                        ResizeBinary($val, $width, $height, 100, $plugins);
                    }

                    // Write file type
                    if ($fileTypeFld != "" && !EmptyValue($row[$fileTypeFld])) {
                        AddHeader("Content-type", $row[$fileTypeFld]);
                    } else {
                        AddHeader("Content-type", ContentType($val));
                    }

                    // Write file name
                    $downloadPdf = !Config("EMBED_PDF") && Config("DOWNLOAD_PDF_FILE");
                    if ($fileNameFld != "" && !EmptyValue($row[$fileNameFld])) {
                        $fileName = $row[$fileNameFld];
                        $pathinfo = pathinfo($fileName);
                        $ext = strtolower(@$pathinfo["extension"]);
                        $isPdf = SameText($ext, "pdf");
                        if ($downloadPdf || !$isPdf) { // Skip header if not download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    } else {
                        $ext = ContentExtension($val);
                        $isPdf = SameText($ext, ".pdf");
                        if ($isPdf && $downloadPdf) { // Add header if download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    }

                    // Write file data
                    if (
                        StartsString("PK", $val) &&
                        ContainsString($val, "[Content_Types].xml") &&
                        ContainsString($val, "_rels") &&
                        ContainsString($val, "docProps")
                    ) { // Fix Office 2007 documents
                        if (!EndsString("\0\0\0", $val)) { // Not ends with 3 or 4 \0
                            $val .= "\0\0\0\0";
                        }
                    }

                    // Clear any debug message
                    if (ob_get_length()) {
                        ob_end_clean();
                    }

                    // Write binary data
                    Write($val);

                // Upload to folder
                } else {
                    if ($fld->UploadMultiple) {
                        $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                    } else {
                        $files = [$val];
                    }
                    $data = [];
                    $ar = [];
                    foreach ($files as $file) {
                        if (!EmptyValue($file)) {
                            if (Config("ENCRYPT_FILE_PATH")) {
                                $ar[$file] = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $this->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                            } else {
                                $ar[$file] = FullUrl($fld->hrefPath() . $file);
                            }
                        }
                    }
                    $data[$fld->Param] = $ar;
                    WriteJson($data);
                }
            }
            return true;
        }
        return false;
    }

    // Table level events

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        if(!empty($rsnew["gambar"])){
        	$nomr = ExecuteScalar("SELECT COUNT(1) FROM `w_testimoni`") + 1;
        	$nama_file_baru = str_replace(' ', '-', $rsnew["nama"]);
        	$ext = pathinfo($rsnew["gambar"], PATHINFO_EXTENSION);
        	$rsnew["gambar"] = "Testimoni_" . $nomr . "_" . $nama_file_baru . "." . $ext;		
    	}
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        if(!empty($rsnew["gambar"])){
          $nomr = $rsold["testimoni_id"];
          $nama_file_baru = str_replace(' ', '-', $rsnew["nama"]);
          $ext = pathinfo($rsnew["gambar"], PATHINFO_EXTENSION);
          $rsnew["gambar"] = "Testimoni_" . $nomr . "_" . $nama_file_baru . "." . $ext;		
    	}	
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email); var_dump($args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
