<?php

namespace PHPMaker2021\ppejp_web;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for konfimasi_pembayaran
 */
class KonfimasiPembayaran extends DbTable
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
    public $order_id;
    public $judul_pelatihan;
    public $tanggal_pelaksanaan;
    public $harga;
    public $tgl_tranfer;
    public $bukti_pembayaran;
    public $_username;
    public $status;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'konfimasi_pembayaran';
        $this->TableName = 'konfimasi_pembayaran';
        $this->TableType = 'CUSTOMVIEW';

        // Update Table
        $this->UpdateTable = "w_orders INNER JOIN w_pelatihan ON w_orders.pelatihan_id = w_pelatihan.pelatihan_id";
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

        // order_id
        $this->order_id = new DbField('konfimasi_pembayaran', 'konfimasi_pembayaran', 'x_order_id', 'order_id', 'w_orders.order_id', 'w_orders.order_id', 3, 9, -1, false, 'w_orders.order_id', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->order_id->IsAutoIncrement = true; // Autoincrement field
        $this->order_id->IsPrimaryKey = true; // Primary key field
        $this->order_id->Sortable = true; // Allow sort
        $this->order_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->order_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->order_id->Param, "CustomMsg");
        $this->Fields['order_id'] = &$this->order_id;

        // judul_pelatihan
        $this->judul_pelatihan = new DbField('konfimasi_pembayaran', 'konfimasi_pembayaran', 'x_judul_pelatihan', 'judul_pelatihan', 'w_pelatihan.judul_pelatihan', 'w_pelatihan.judul_pelatihan', 200, 255, -1, false, 'w_pelatihan.judul_pelatihan', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->judul_pelatihan->Nullable = false; // NOT NULL field
        $this->judul_pelatihan->Required = true; // Required field
        $this->judul_pelatihan->Sortable = true; // Allow sort
        $this->judul_pelatihan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->judul_pelatihan->Param, "CustomMsg");
        $this->Fields['judul_pelatihan'] = &$this->judul_pelatihan;

        // tanggal_pelaksanaan
        $this->tanggal_pelaksanaan = new DbField('konfimasi_pembayaran', 'konfimasi_pembayaran', 'x_tanggal_pelaksanaan', 'tanggal_pelaksanaan', 'w_pelatihan.tanggal_pelaksanaan', 'w_pelatihan.tanggal_pelaksanaan', 200, 100, -1, false, 'w_pelatihan.tanggal_pelaksanaan', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tanggal_pelaksanaan->Nullable = false; // NOT NULL field
        $this->tanggal_pelaksanaan->Required = true; // Required field
        $this->tanggal_pelaksanaan->Sortable = true; // Allow sort
        $this->tanggal_pelaksanaan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal_pelaksanaan->Param, "CustomMsg");
        $this->Fields['tanggal_pelaksanaan'] = &$this->tanggal_pelaksanaan;

        // harga
        $this->harga = new DbField('konfimasi_pembayaran', 'konfimasi_pembayaran', 'x_harga', 'harga', 'w_pelatihan.harga', 'w_pelatihan.harga', 131, 10, -1, false, 'w_pelatihan.harga', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->harga->Nullable = false; // NOT NULL field
        $this->harga->Required = true; // Required field
        $this->harga->Sortable = true; // Allow sort
        $this->harga->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->harga->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->harga->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->harga->Param, "CustomMsg");
        $this->Fields['harga'] = &$this->harga;

        // tgl_tranfer
        $this->tgl_tranfer = new DbField('konfimasi_pembayaran', 'konfimasi_pembayaran', 'x_tgl_tranfer', 'tgl_tranfer', 'w_orders.tgl_tranfer', CastDateFieldForLike("w_orders.tgl_tranfer", 0, "DB"), 133, 10, 0, false, 'w_orders.tgl_tranfer', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tgl_tranfer->Sortable = true; // Allow sort
        $this->tgl_tranfer->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tgl_tranfer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tgl_tranfer->Param, "CustomMsg");
        $this->Fields['tgl_tranfer'] = &$this->tgl_tranfer;

        // bukti_pembayaran
        $this->bukti_pembayaran = new DbField('konfimasi_pembayaran', 'konfimasi_pembayaran', 'x_bukti_pembayaran', 'bukti_pembayaran', 'w_orders.bukti_pembayaran', 'w_orders.bukti_pembayaran', 200, 255, -1, true, 'w_orders.bukti_pembayaran', false, false, false, 'FORMATTED TEXT', 'FILE');
        $this->bukti_pembayaran->Required = true; // Required field
        $this->bukti_pembayaran->Sortable = true; // Allow sort
        $this->bukti_pembayaran->UploadAllowedFileExt = "jpg,jpeg,png";
        $this->bukti_pembayaran->UploadMaxFileSize = 2000000;
        $this->bukti_pembayaran->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bukti_pembayaran->Param, "CustomMsg");
        $this->Fields['bukti_pembayaran'] = &$this->bukti_pembayaran;

        // username
        $this->_username = new DbField('konfimasi_pembayaran', 'konfimasi_pembayaran', 'x__username', 'username', 'w_orders.username', 'w_orders.username', 200, 50, -1, false, 'w_orders.username', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->_username->Nullable = false; // NOT NULL field
        $this->_username->Required = true; // Required field
        $this->_username->Sortable = true; // Allow sort
        $this->_username->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->_username->Param, "CustomMsg");
        $this->Fields['username'] = &$this->_username;

        // status
        $this->status = new DbField('konfimasi_pembayaran', 'konfimasi_pembayaran', 'x_status', 'status', 'w_orders.status', 'w_orders.status', 16, 4, -1, false, 'w_orders.status', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->status->Nullable = false; // NOT NULL field
        $this->status->Sortable = true; // Allow sort
        $this->status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->status->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->status->Param, "CustomMsg");
        $this->Fields['status'] = &$this->status;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "w_orders INNER JOIN w_pelatihan ON w_orders.pelatihan_id = w_pelatihan.pelatihan_id";
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
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("w_orders.order_id, w_orders.bukti_pembayaran, w_pelatihan.judul_pelatihan, w_pelatihan.tanggal_pelaksanaan, w_pelatihan.harga, w_orders.username, w_orders.status, w_orders.tgl_tranfer");
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
            $this->order_id->setDbValue($conn->lastInsertId());
            $rs['order_id'] = $this->order_id->DbValue;
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
            if (array_key_exists('order_id', $rs)) {
                AddFilter($where, QuotedName('order_id', $this->Dbid) . '=' . QuotedValue($rs['order_id'], $this->order_id->DataType, $this->Dbid));
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
        $this->order_id->DbValue = $row['order_id'];
        $this->judul_pelatihan->DbValue = $row['judul_pelatihan'];
        $this->tanggal_pelaksanaan->DbValue = $row['tanggal_pelaksanaan'];
        $this->harga->DbValue = $row['harga'];
        $this->tgl_tranfer->DbValue = $row['tgl_tranfer'];
        $this->bukti_pembayaran->Upload->DbValue = $row['bukti_pembayaran'];
        $this->_username->DbValue = $row['username'];
        $this->status->DbValue = $row['status'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $this->bukti_pembayaran->OldUploadPath = "files/bukti_pembayaran/";
        $oldFiles = EmptyValue($row['bukti_pembayaran']) ? [] : [$row['bukti_pembayaran']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->bukti_pembayaran->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->bukti_pembayaran->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "w_orders.order_id = @order_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->order_id->CurrentValue : $this->order_id->OldValue;
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
                $this->order_id->CurrentValue = $keys[0];
            } else {
                $this->order_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('order_id', $row) ? $row['order_id'] : null;
        } else {
            $val = $this->order_id->OldValue !== null ? $this->order_id->OldValue : $this->order_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@order_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("konfimasipembayaranlist");
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
        if ($pageName == "konfimasipembayaranview") {
            return $Language->phrase("View");
        } elseif ($pageName == "konfimasipembayaranedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "konfimasipembayaranadd") {
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
                return "KonfimasiPembayaranView";
            case Config("API_ADD_ACTION"):
                return "KonfimasiPembayaranAdd";
            case Config("API_EDIT_ACTION"):
                return "KonfimasiPembayaranEdit";
            case Config("API_DELETE_ACTION"):
                return "KonfimasiPembayaranDelete";
            case Config("API_LIST_ACTION"):
                return "KonfimasiPembayaranList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "konfimasipembayaranlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("konfimasipembayaranview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("konfimasipembayaranview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "konfimasipembayaranadd?" . $this->getUrlParm($parm);
        } else {
            $url = "konfimasipembayaranadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("konfimasipembayaranedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("konfimasipembayaranadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("konfimasipembayarandelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "order_id:" . JsonEncode($this->order_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->order_id->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->order_id->CurrentValue);
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
            if (($keyValue = Param("order_id") ?? Route("order_id")) !== null) {
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
                $this->order_id->CurrentValue = $key;
            } else {
                $this->order_id->OldValue = $key;
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
        $this->order_id->setDbValue($row['order_id']);
        $this->judul_pelatihan->setDbValue($row['judul_pelatihan']);
        $this->tanggal_pelaksanaan->setDbValue($row['tanggal_pelaksanaan']);
        $this->harga->setDbValue($row['harga']);
        $this->tgl_tranfer->setDbValue($row['tgl_tranfer']);
        $this->bukti_pembayaran->Upload->DbValue = $row['bukti_pembayaran'];
        $this->bukti_pembayaran->setDbValue($this->bukti_pembayaran->Upload->DbValue);
        $this->_username->setDbValue($row['username']);
        $this->status->setDbValue($row['status']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // order_id

        // judul_pelatihan

        // tanggal_pelaksanaan

        // harga

        // tgl_tranfer

        // bukti_pembayaran

        // username

        // status

        // order_id
        $this->order_id->ViewValue = $this->order_id->CurrentValue;
        $this->order_id->ViewCustomAttributes = "";

        // judul_pelatihan
        $this->judul_pelatihan->ViewValue = $this->judul_pelatihan->CurrentValue;
        $this->judul_pelatihan->ViewCustomAttributes = "";

        // tanggal_pelaksanaan
        $this->tanggal_pelaksanaan->ViewValue = $this->tanggal_pelaksanaan->CurrentValue;
        $this->tanggal_pelaksanaan->ViewCustomAttributes = "";

        // harga
        $this->harga->ViewValue = $this->harga->CurrentValue;
        $this->harga->ViewValue = FormatNumber($this->harga->ViewValue, 2, -2, -2, -2);
        $this->harga->ViewCustomAttributes = "";

        // tgl_tranfer
        $this->tgl_tranfer->ViewValue = $this->tgl_tranfer->CurrentValue;
        $this->tgl_tranfer->ViewValue = FormatDateTime($this->tgl_tranfer->ViewValue, 0);
        $this->tgl_tranfer->ViewCustomAttributes = "";

        // bukti_pembayaran
        $this->bukti_pembayaran->UploadPath = "files/bukti_pembayaran/";
        if (!EmptyValue($this->bukti_pembayaran->Upload->DbValue)) {
            $this->bukti_pembayaran->ViewValue = $this->bukti_pembayaran->Upload->DbValue;
        } else {
            $this->bukti_pembayaran->ViewValue = "";
        }
        $this->bukti_pembayaran->ViewCustomAttributes = "";

        // username
        $this->_username->ViewValue = $this->_username->CurrentValue;
        $this->_username->ViewCustomAttributes = "";

        // status
        $this->status->ViewValue = $this->status->CurrentValue;
        $this->status->ViewValue = FormatNumber($this->status->ViewValue, 0, -2, -2, -2);
        $this->status->ViewCustomAttributes = "";

        // order_id
        $this->order_id->LinkCustomAttributes = "";
        $this->order_id->HrefValue = "";
        $this->order_id->TooltipValue = "";

        // judul_pelatihan
        $this->judul_pelatihan->LinkCustomAttributes = "";
        $this->judul_pelatihan->HrefValue = "";
        $this->judul_pelatihan->TooltipValue = "";

        // tanggal_pelaksanaan
        $this->tanggal_pelaksanaan->LinkCustomAttributes = "";
        $this->tanggal_pelaksanaan->HrefValue = "";
        $this->tanggal_pelaksanaan->TooltipValue = "";

        // harga
        $this->harga->LinkCustomAttributes = "";
        $this->harga->HrefValue = "";
        $this->harga->TooltipValue = "";

        // tgl_tranfer
        $this->tgl_tranfer->LinkCustomAttributes = "";
        $this->tgl_tranfer->HrefValue = "";
        $this->tgl_tranfer->TooltipValue = "";

        // bukti_pembayaran
        $this->bukti_pembayaran->LinkCustomAttributes = "";
        $this->bukti_pembayaran->HrefValue = "";
        $this->bukti_pembayaran->ExportHrefValue = $this->bukti_pembayaran->UploadPath . $this->bukti_pembayaran->Upload->DbValue;
        $this->bukti_pembayaran->TooltipValue = "";

        // username
        $this->_username->LinkCustomAttributes = "";
        $this->_username->HrefValue = "";
        $this->_username->TooltipValue = "";

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

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

        // order_id
        $this->order_id->EditAttrs["class"] = "form-control";
        $this->order_id->EditCustomAttributes = "";
        $this->order_id->EditValue = $this->order_id->CurrentValue;
        $this->order_id->ViewCustomAttributes = "";

        // judul_pelatihan
        $this->judul_pelatihan->EditAttrs["class"] = "form-control";
        $this->judul_pelatihan->EditCustomAttributes = "";
        $this->judul_pelatihan->EditValue = $this->judul_pelatihan->CurrentValue;
        $this->judul_pelatihan->ViewCustomAttributes = "";

        // tanggal_pelaksanaan
        $this->tanggal_pelaksanaan->EditAttrs["class"] = "form-control";
        $this->tanggal_pelaksanaan->EditCustomAttributes = "";
        $this->tanggal_pelaksanaan->EditValue = $this->tanggal_pelaksanaan->CurrentValue;
        $this->tanggal_pelaksanaan->ViewCustomAttributes = "";

        // harga
        $this->harga->EditAttrs["class"] = "form-control";
        $this->harga->EditCustomAttributes = "";
        $this->harga->EditValue = $this->harga->CurrentValue;
        $this->harga->EditValue = FormatNumber($this->harga->EditValue, 2, -2, -2, -2);
        $this->harga->ViewCustomAttributes = "";

        // tgl_tranfer
        $this->tgl_tranfer->EditAttrs["class"] = "form-control";
        $this->tgl_tranfer->EditCustomAttributes = "";
        $this->tgl_tranfer->EditValue = FormatDateTime($this->tgl_tranfer->CurrentValue, 8);
        $this->tgl_tranfer->PlaceHolder = RemoveHtml($this->tgl_tranfer->caption());

        // bukti_pembayaran
        $this->bukti_pembayaran->EditAttrs["class"] = "form-control";
        $this->bukti_pembayaran->EditCustomAttributes = "";
        $this->bukti_pembayaran->UploadPath = "files/bukti_pembayaran/";
        if (!EmptyValue($this->bukti_pembayaran->Upload->DbValue)) {
            $this->bukti_pembayaran->EditValue = $this->bukti_pembayaran->Upload->DbValue;
        } else {
            $this->bukti_pembayaran->EditValue = "";
        }
        if (!EmptyValue($this->bukti_pembayaran->CurrentValue)) {
            $this->bukti_pembayaran->Upload->FileName = $this->bukti_pembayaran->CurrentValue;
        }

        // username
        $this->_username->EditAttrs["class"] = "form-control";
        $this->_username->EditCustomAttributes = "";
        if (!$this->_username->Raw) {
            $this->_username->CurrentValue = HtmlDecode($this->_username->CurrentValue);
        }
        $this->_username->EditValue = $this->_username->CurrentValue;
        $this->_username->PlaceHolder = RemoveHtml($this->_username->caption());

        // status
        $this->status->EditAttrs["class"] = "form-control";
        $this->status->EditCustomAttributes = "";
        $this->status->EditValue = $this->status->CurrentValue;
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

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
                    $doc->exportCaption($this->order_id);
                    $doc->exportCaption($this->judul_pelatihan);
                    $doc->exportCaption($this->tanggal_pelaksanaan);
                    $doc->exportCaption($this->harga);
                    $doc->exportCaption($this->tgl_tranfer);
                    $doc->exportCaption($this->bukti_pembayaran);
                    $doc->exportCaption($this->status);
                } else {
                    $doc->exportCaption($this->order_id);
                    $doc->exportCaption($this->judul_pelatihan);
                    $doc->exportCaption($this->tanggal_pelaksanaan);
                    $doc->exportCaption($this->harga);
                    $doc->exportCaption($this->tgl_tranfer);
                    $doc->exportCaption($this->bukti_pembayaran);
                    $doc->exportCaption($this->status);
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
                        $doc->exportField($this->order_id);
                        $doc->exportField($this->judul_pelatihan);
                        $doc->exportField($this->tanggal_pelaksanaan);
                        $doc->exportField($this->harga);
                        $doc->exportField($this->tgl_tranfer);
                        $doc->exportField($this->bukti_pembayaran);
                        $doc->exportField($this->status);
                    } else {
                        $doc->exportField($this->order_id);
                        $doc->exportField($this->judul_pelatihan);
                        $doc->exportField($this->tanggal_pelaksanaan);
                        $doc->exportField($this->harga);
                        $doc->exportField($this->tgl_tranfer);
                        $doc->exportField($this->bukti_pembayaran);
                        $doc->exportField($this->status);
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
        if ($fldparm == 'bukti_pembayaran') {
            $fldName = "bukti_pembayaran";
            $fileNameFld = "bukti_pembayaran";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->order_id->CurrentValue = $ar[0];
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
        if(CurrentUserLevel() == 0){
        	AddFilter($filter, "username = '".CurrentUserName()."'");
        }
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
    	$ext = pathinfo($rsnew["bukti_pembayaran"], PATHINFO_EXTENSION);
        $rsnew["bukti_pembayaran"] = $rsold["order_id"] . "_" . CurrentUserInfo("user_id") . "." . $ext;

    	//update status menunggu verifikasi
    	$rsnew["status"] = 2;
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
