<?php

namespace PHPMaker2021\ppejp_web;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for w_orders
 */
class WOrders extends DbTable
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
    public $nama_peserta;
    public $_username;
    public $nama_perusahaan;
    public $pelatihan_id;
    public $Biaya;
    public $tgl_tranfer;
    public $bukti_pembayaran;
    public $created_at;
    public $updated_at;
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
        $this->TableVar = 'w_orders';
        $this->TableName = 'w_orders';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`w_orders`";
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
        $this->order_id = new DbField('w_orders', 'w_orders', 'x_order_id', 'order_id', '`order_id`', '`order_id`', 3, 9, -1, false, '`order_id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->order_id->IsAutoIncrement = true; // Autoincrement field
        $this->order_id->IsPrimaryKey = true; // Primary key field
        $this->order_id->Sortable = true; // Allow sort
        $this->order_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->order_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->order_id->Param, "CustomMsg");
        $this->Fields['order_id'] = &$this->order_id;

        // nama_peserta
        $this->nama_peserta = new DbField('w_orders', 'w_orders', 'x_nama_peserta', 'nama_peserta', '`nama_peserta`', '`nama_peserta`', 200, 200, -1, false, '`nama_peserta`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama_peserta->Nullable = false; // NOT NULL field
        $this->nama_peserta->Required = true; // Required field
        $this->nama_peserta->Sortable = true; // Allow sort
        $this->nama_peserta->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama_peserta->Param, "CustomMsg");
        $this->Fields['nama_peserta'] = &$this->nama_peserta;

        // username
        $this->_username = new DbField('w_orders', 'w_orders', 'x__username', 'username', '`username`', '`username`', 200, 50, -1, false, '`username`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->_username->Nullable = false; // NOT NULL field
        $this->_username->Sortable = true; // Allow sort
        $this->_username->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->_username->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->_username->Lookup = new Lookup('username', 'w_users', false, 'user_email', ["no_hp","","",""], [], [], [], [], [], [], '', '');
        $this->_username->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->_username->Param, "CustomMsg");
        $this->Fields['username'] = &$this->_username;

        // nama_perusahaan
        $this->nama_perusahaan = new DbField('w_orders', 'w_orders', 'x_nama_perusahaan', 'nama_perusahaan', '`nama_perusahaan`', '`nama_perusahaan`', 200, 255, -1, false, '`nama_perusahaan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama_perusahaan->Nullable = false; // NOT NULL field
        $this->nama_perusahaan->Required = true; // Required field
        $this->nama_perusahaan->Sortable = true; // Allow sort
        $this->nama_perusahaan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama_perusahaan->Param, "CustomMsg");
        $this->Fields['nama_perusahaan'] = &$this->nama_perusahaan;

        // pelatihan_id
        $this->pelatihan_id = new DbField('w_orders', 'w_orders', 'x_pelatihan_id', 'pelatihan_id', '`pelatihan_id`', '`pelatihan_id`', 3, 9, -1, false, '`pelatihan_id`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->pelatihan_id->Nullable = false; // NOT NULL field
        $this->pelatihan_id->Required = true; // Required field
        $this->pelatihan_id->Sortable = true; // Allow sort
        $this->pelatihan_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->pelatihan_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->pelatihan_id->Lookup = new Lookup('pelatihan_id', 'w_pelatihan', false, 'pelatihan_id', ["judul_pelatihan","tanggal_pelaksanaan","",""], [], [], [], [], [], [], '`judul_pelatihan` ASC', '<spanclass="text-info">{{:df1}}</span> <smallclass="text-muted">({{:df2}})</small>');
        $this->pelatihan_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->pelatihan_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pelatihan_id->Param, "CustomMsg");
        $this->Fields['pelatihan_id'] = &$this->pelatihan_id;

        // Biaya
        $this->Biaya = new DbField('w_orders', 'w_orders', 'x_Biaya', 'Biaya', 'NULL', 'NULL', 12, 65530, -1, false, 'NULL', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Biaya->IsCustom = true; // Custom field
        $this->Biaya->Sortable = true; // Allow sort
        $this->Biaya->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Biaya->Param, "CustomMsg");
        $this->Fields['Biaya'] = &$this->Biaya;

        // tgl_tranfer
        $this->tgl_tranfer = new DbField('w_orders', 'w_orders', 'x_tgl_tranfer', 'tgl_tranfer', '`tgl_tranfer`', CastDateFieldForLike("`tgl_tranfer`", 0, "DB"), 133, 10, 0, false, '`tgl_tranfer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tgl_tranfer->Sortable = true; // Allow sort
        $this->tgl_tranfer->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tgl_tranfer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tgl_tranfer->Param, "CustomMsg");
        $this->Fields['tgl_tranfer'] = &$this->tgl_tranfer;

        // bukti_pembayaran
        $this->bukti_pembayaran = new DbField('w_orders', 'w_orders', 'x_bukti_pembayaran', 'bukti_pembayaran', '`bukti_pembayaran`', '`bukti_pembayaran`', 200, 255, -1, true, '`bukti_pembayaran`', false, false, false, 'IMAGE', 'FILE');
        $this->bukti_pembayaran->Sortable = true; // Allow sort
        $this->bukti_pembayaran->ImageResize = true;
        $this->bukti_pembayaran->UploadAllowedFileExt = "jpg,jpeg,png";
        $this->bukti_pembayaran->UploadMaxFileSize = 2000000;
        $this->bukti_pembayaran->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bukti_pembayaran->Param, "CustomMsg");
        $this->Fields['bukti_pembayaran'] = &$this->bukti_pembayaran;

        // created_at
        $this->created_at = new DbField('w_orders', 'w_orders', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Nullable = false; // NOT NULL field
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

        // updated_at
        $this->updated_at = new DbField('w_orders', 'w_orders', 'x_updated_at', 'updated_at', '`updated_at`', CastDateFieldForLike("`updated_at`", 0, "DB"), 135, 19, 0, false, '`updated_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->updated_at->Nullable = false; // NOT NULL field
        $this->updated_at->Sortable = true; // Allow sort
        $this->updated_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->updated_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->updated_at->Param, "CustomMsg");
        $this->Fields['updated_at'] = &$this->updated_at;

        // status
        $this->status = new DbField('w_orders', 'w_orders', 'x_status', 'status', '`status`', '`status`', 16, 4, -1, false, '`status`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->status->Nullable = false; // NOT NULL field
        $this->status->Sortable = true; // Allow sort
        $this->status->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->status->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->status->Lookup = new Lookup('status', 'w_orders', false, '', ["","","",""], [], [], [], [], [], [], '', '');
        $this->status->OptionCount = 6;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`w_orders`";
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
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*, NULL AS `Biaya`");
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
        $this->nama_peserta->DbValue = $row['nama_peserta'];
        $this->_username->DbValue = $row['username'];
        $this->nama_perusahaan->DbValue = $row['nama_perusahaan'];
        $this->pelatihan_id->DbValue = $row['pelatihan_id'];
        $this->Biaya->DbValue = $row['Biaya'];
        $this->tgl_tranfer->DbValue = $row['tgl_tranfer'];
        $this->bukti_pembayaran->Upload->DbValue = $row['bukti_pembayaran'];
        $this->created_at->DbValue = $row['created_at'];
        $this->updated_at->DbValue = $row['updated_at'];
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
        return "`order_id` = @order_id@";
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
        return $_SESSION[$name] ?? GetUrl("worderslist");
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
        if ($pageName == "wordersview") {
            return $Language->phrase("View");
        } elseif ($pageName == "wordersedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "wordersadd") {
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
                return "WOrdersView";
            case Config("API_ADD_ACTION"):
                return "WOrdersAdd";
            case Config("API_EDIT_ACTION"):
                return "WOrdersEdit";
            case Config("API_DELETE_ACTION"):
                return "WOrdersDelete";
            case Config("API_LIST_ACTION"):
                return "WOrdersList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "worderslist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("wordersview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("wordersview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "wordersadd?" . $this->getUrlParm($parm);
        } else {
            $url = "wordersadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("wordersedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("wordersadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("wordersdelete", $this->getUrlParm());
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

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

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

        // order_id
        $this->order_id->LinkCustomAttributes = "";
        $this->order_id->HrefValue = "";
        $this->order_id->TooltipValue = "";

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
            $this->bukti_pembayaran->LinkAttrs["data-rel"] = "w_orders_x_bukti_pembayaran";
            $this->bukti_pembayaran->LinkAttrs->appendClass("ew-lightbox");
        }

        // created_at
        $this->created_at->LinkCustomAttributes = "";
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

        // updated_at
        $this->updated_at->LinkCustomAttributes = "";
        $this->updated_at->HrefValue = "";
        $this->updated_at->TooltipValue = "";

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

        // nama_peserta
        $this->nama_peserta->EditAttrs["class"] = "form-control";
        $this->nama_peserta->EditCustomAttributes = "";
        $this->nama_peserta->EditValue = $this->nama_peserta->CurrentValue;
        $this->nama_peserta->ViewCustomAttributes = "";

        // username

        // nama_perusahaan
        $this->nama_perusahaan->EditAttrs["class"] = "form-control";
        $this->nama_perusahaan->EditCustomAttributes = "";
        $this->nama_perusahaan->EditValue = $this->nama_perusahaan->CurrentValue;
        $this->nama_perusahaan->ViewCustomAttributes = "";

        // pelatihan_id
        $this->pelatihan_id->EditAttrs["class"] = "form-control";
        $this->pelatihan_id->EditCustomAttributes = "";
        $curVal = trim(strval($this->pelatihan_id->CurrentValue));
        if ($curVal != "") {
            $this->pelatihan_id->EditValue = $this->pelatihan_id->lookupCacheOption($curVal);
            if ($this->pelatihan_id->EditValue === null) { // Lookup from database
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
                    $this->pelatihan_id->EditValue = $this->pelatihan_id->displayValue($arwrk);
                } else {
                    $this->pelatihan_id->EditValue = $this->pelatihan_id->CurrentValue;
                }
            }
        } else {
            $this->pelatihan_id->EditValue = null;
        }
        $this->pelatihan_id->ViewCustomAttributes = "";

        // Biaya
        $this->Biaya->EditAttrs["class"] = "form-control";
        $this->Biaya->EditCustomAttributes = "";
        $this->Biaya->EditValue = $this->Biaya->CurrentValue;
        $this->Biaya->ViewCustomAttributes = "";

        // tgl_tranfer
        $this->tgl_tranfer->EditAttrs["class"] = "form-control";
        $this->tgl_tranfer->EditCustomAttributes = "";
        $this->tgl_tranfer->EditValue = FormatDateTime($this->tgl_tranfer->CurrentValue, 8);
        $this->tgl_tranfer->PlaceHolder = RemoveHtml($this->tgl_tranfer->caption());

        // bukti_pembayaran
        $this->bukti_pembayaran->EditAttrs["class"] = "form-control";
        $this->bukti_pembayaran->EditCustomAttributes = "style='width:300px;'";
        $this->bukti_pembayaran->UploadPath = "files/bukti_pembayaran/";
        if (!EmptyValue($this->bukti_pembayaran->Upload->DbValue)) {
            $this->bukti_pembayaran->ImageWidth = 200;
            $this->bukti_pembayaran->ImageHeight = 0;
            $this->bukti_pembayaran->ImageAlt = $this->bukti_pembayaran->alt();
            $this->bukti_pembayaran->EditValue = $this->bukti_pembayaran->Upload->DbValue;
        } else {
            $this->bukti_pembayaran->EditValue = "";
        }
        if (!EmptyValue($this->bukti_pembayaran->CurrentValue)) {
            $this->bukti_pembayaran->Upload->FileName = $this->bukti_pembayaran->CurrentValue;
        }

        // created_at

        // updated_at

        // status
        $this->status->EditAttrs["class"] = "form-control";
        $this->status->EditCustomAttributes = "";
        $this->status->EditValue = $this->status->options(true);
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
                    $doc->exportCaption($this->nama_peserta);
                    $doc->exportCaption($this->nama_perusahaan);
                    $doc->exportCaption($this->pelatihan_id);
                    $doc->exportCaption($this->Biaya);
                    $doc->exportCaption($this->tgl_tranfer);
                    $doc->exportCaption($this->bukti_pembayaran);
                    $doc->exportCaption($this->status);
                } else {
                    $doc->exportCaption($this->order_id);
                    $doc->exportCaption($this->nama_peserta);
                    $doc->exportCaption($this->_username);
                    $doc->exportCaption($this->nama_perusahaan);
                    $doc->exportCaption($this->pelatihan_id);
                    $doc->exportCaption($this->Biaya);
                    $doc->exportCaption($this->tgl_tranfer);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->updated_at);
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
                        $doc->exportField($this->nama_peserta);
                        $doc->exportField($this->nama_perusahaan);
                        $doc->exportField($this->pelatihan_id);
                        $doc->exportField($this->Biaya);
                        $doc->exportField($this->tgl_tranfer);
                        $doc->exportField($this->bukti_pembayaran);
                        $doc->exportField($this->status);
                    } else {
                        $doc->exportField($this->order_id);
                        $doc->exportField($this->nama_peserta);
                        $doc->exportField($this->_username);
                        $doc->exportField($this->nama_perusahaan);
                        $doc->exportField($this->pelatihan_id);
                        $doc->exportField($this->Biaya);
                        $doc->exportField($this->tgl_tranfer);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->updated_at);
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
        if ($this->PageID == "list" || $this->PageID == "view") { // List/View page only
            if ($this->status->CurrentValue == 1) {
                 $this->status->ViewAttrs["class"] = "text-danger";
            } elseif ($this->status->CurrentValue == 2) {
                 $this->status->ViewAttrs["class"] = "text-warning";
            } elseif ($this->status->CurrentValue == 3) {
                 $this->status->ViewAttrs["class"] = "text-text-success";
            } elseif ($this->status->CurrentValue == 4) {
                 $this->status->ViewAttrs["class"] = "text-text-success";
            } else {
            	$this->status->ViewAttrs["class"] = "text-text-default";
            }
            $val = ExecuteScalar("SELECT `harga` FROM `w_pelatihan` WHERE `pelatihan_id` = '".$this->pelatihan_id->CurrentValue."'");
    		$this->Biaya->ViewValue = rupiah($val);
    		$nohp= str_replace("-","",str_replace(" ","",$this->_username->ViewValue));
    		$this->nama_peserta->ViewValue = $this->nama_peserta->ViewValue . " ( <a target='_blank' href='https://wa.me/".$nohp."'>".$this->_username->ViewValue."</a> )";
        }
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
