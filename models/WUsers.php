<?php

namespace PHPMaker2021\ppejp_web;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for w_users
 */
class WUsers extends DbTable
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
    public $user_id;
    public $user_email;
    public $no_hp;
    public $pass;
    public $_userlevel;
    public $aktif;
    public $created_at;
    public $user_created_by;
    public $updated_at;
    public $user_updated_by;
    public $nama_peserta;
    public $perusahaan;
    public $jabatan;
    public $provinsi;
    public $kota;
    public $usaha;
    public $produk;
    public $last_login;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'w_users';
        $this->TableName = 'w_users';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`w_users`";
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

        // user_id
        $this->user_id = new DbField('w_users', 'w_users', 'x_user_id', 'user_id', '`user_id`', '`user_id`', 3, 11, -1, false, '`user_id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->user_id->IsAutoIncrement = true; // Autoincrement field
        $this->user_id->IsPrimaryKey = true; // Primary key field
        $this->user_id->Sortable = true; // Allow sort
        $this->user_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->user_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->user_id->Param, "CustomMsg");
        $this->Fields['user_id'] = &$this->user_id;

        // user_email
        $this->user_email = new DbField('w_users', 'w_users', 'x_user_email', 'user_email', '`user_email`', '`user_email`', 200, 25, -1, false, '`user_email`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->user_email->Nullable = false; // NOT NULL field
        $this->user_email->Required = true; // Required field
        $this->user_email->Sortable = true; // Allow sort
        $this->user_email->DefaultErrorMessage = $Language->phrase("IncorrectEmail");
        $this->user_email->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->user_email->Param, "CustomMsg");
        $this->Fields['user_email'] = &$this->user_email;

        // no_hp
        $this->no_hp = new DbField('w_users', 'w_users', 'x_no_hp', 'no_hp', '`no_hp`', '`no_hp`', 200, 25, -1, false, '`no_hp`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->no_hp->Nullable = false; // NOT NULL field
        $this->no_hp->Required = true; // Required field
        $this->no_hp->Sortable = true; // Allow sort
        $this->no_hp->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->no_hp->Param, "CustomMsg");
        $this->Fields['no_hp'] = &$this->no_hp;

        // pass
        $this->pass = new DbField('w_users', 'w_users', 'x_pass', 'pass', '`pass`', '`pass`', 201, 65535, -1, false, '`pass`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        if (Config("ENCRYPTED_PASSWORD")) {
            $this->pass->Raw = true;
        }
        $this->pass->Required = true; // Required field
        $this->pass->Sortable = true; // Allow sort
        $this->pass->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->pass->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->pass->Lookup = new Lookup('pass', 'w_userlevels', false, 'userlevelid', ["userlevelname","","",""], [], [], [], [], [], [], '', '');
        $this->pass->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pass->Param, "CustomMsg");
        $this->Fields['pass'] = &$this->pass;

        // userlevel
        $this->_userlevel = new DbField('w_users', 'w_users', 'x__userlevel', 'userlevel', '`userlevel`', '`userlevel`', 3, 11, -1, false, '`userlevel`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->_userlevel->Nullable = false; // NOT NULL field
        $this->_userlevel->Required = true; // Required field
        $this->_userlevel->Sortable = true; // Allow sort
        $this->_userlevel->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->_userlevel->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->_userlevel->Lookup = new Lookup('userlevel', 'w_userlevels', false, 'userlevelid', ["userlevelname","","",""], [], [], [], [], [], [], '', '');
        $this->_userlevel->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->_userlevel->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->_userlevel->Param, "CustomMsg");
        $this->Fields['userlevel'] = &$this->_userlevel;

        // aktif
        $this->aktif = new DbField('w_users', 'w_users', 'x_aktif', 'aktif', '`aktif`', '`aktif`', 202, 1, -1, false, '`aktif`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->aktif->Nullable = false; // NOT NULL field
        $this->aktif->Sortable = true; // Allow sort
        $this->aktif->DataType = DATATYPE_BOOLEAN;
        $this->aktif->TrueValue = "Y";
        $this->aktif->FalseValue = "N";
        $this->aktif->Lookup = new Lookup('aktif', 'w_users', false, '', ["","","",""], [], [], [], [], [], [], '', '');
        $this->aktif->OptionCount = 2;
        $this->aktif->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aktif->Param, "CustomMsg");
        $this->Fields['aktif'] = &$this->aktif;

        // created_at
        $this->created_at = new DbField('w_users', 'w_users', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

        // user_created_by
        $this->user_created_by = new DbField('w_users', 'w_users', 'x_user_created_by', 'user_created_by', '`user_created_by`', '`user_created_by`', 200, 100, -1, false, '`user_created_by`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->user_created_by->Sortable = true; // Allow sort
        $this->user_created_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->user_created_by->Param, "CustomMsg");
        $this->Fields['user_created_by'] = &$this->user_created_by;

        // updated_at
        $this->updated_at = new DbField('w_users', 'w_users', 'x_updated_at', 'updated_at', '`updated_at`', CastDateFieldForLike("`updated_at`", 0, "DB"), 135, 19, 0, false, '`updated_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->updated_at->Sortable = true; // Allow sort
        $this->updated_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->updated_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->updated_at->Param, "CustomMsg");
        $this->Fields['updated_at'] = &$this->updated_at;

        // user_updated_by
        $this->user_updated_by = new DbField('w_users', 'w_users', 'x_user_updated_by', 'user_updated_by', '`user_updated_by`', '`user_updated_by`', 200, 100, -1, false, '`user_updated_by`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->user_updated_by->Sortable = true; // Allow sort
        $this->user_updated_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->user_updated_by->Param, "CustomMsg");
        $this->Fields['user_updated_by'] = &$this->user_updated_by;

        // nama_peserta
        $this->nama_peserta = new DbField('w_users', 'w_users', 'x_nama_peserta', 'nama_peserta', '`nama_peserta`', '`nama_peserta`', 200, 200, -1, false, '`nama_peserta`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama_peserta->Nullable = false; // NOT NULL field
        $this->nama_peserta->Required = true; // Required field
        $this->nama_peserta->Sortable = true; // Allow sort
        $this->nama_peserta->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama_peserta->Param, "CustomMsg");
        $this->Fields['nama_peserta'] = &$this->nama_peserta;

        // perusahaan
        $this->perusahaan = new DbField('w_users', 'w_users', 'x_perusahaan', 'perusahaan', '`perusahaan`', '`perusahaan`', 200, 200, -1, false, '`perusahaan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->perusahaan->Nullable = false; // NOT NULL field
        $this->perusahaan->Required = true; // Required field
        $this->perusahaan->Sortable = true; // Allow sort
        $this->perusahaan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->perusahaan->Param, "CustomMsg");
        $this->Fields['perusahaan'] = &$this->perusahaan;

        // jabatan
        $this->jabatan = new DbField('w_users', 'w_users', 'x_jabatan', 'jabatan', '`jabatan`', '`jabatan`', 200, 100, -1, false, '`jabatan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jabatan->Nullable = false; // NOT NULL field
        $this->jabatan->Required = true; // Required field
        $this->jabatan->Sortable = true; // Allow sort
        $this->jabatan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jabatan->Param, "CustomMsg");
        $this->Fields['jabatan'] = &$this->jabatan;

        // provinsi
        $this->provinsi = new DbField('w_users', 'w_users', 'x_provinsi', 'provinsi', '`provinsi`', '`provinsi`', 16, 2, -1, false, '`provinsi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->provinsi->Nullable = false; // NOT NULL field
        $this->provinsi->Required = true; // Required field
        $this->provinsi->Sortable = true; // Allow sort
        $this->provinsi->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->provinsi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->provinsi->Param, "CustomMsg");
        $this->Fields['provinsi'] = &$this->provinsi;

        // kota
        $this->kota = new DbField('w_users', 'w_users', 'x_kota', 'kota', '`kota`', '`kota`', 2, 4, -1, false, '`kota`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kota->Nullable = false; // NOT NULL field
        $this->kota->Required = true; // Required field
        $this->kota->Sortable = true; // Allow sort
        $this->kota->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->kota->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kota->Param, "CustomMsg");
        $this->Fields['kota'] = &$this->kota;

        // usaha
        $this->usaha = new DbField('w_users', 'w_users', 'x_usaha', 'usaha', '`usaha`', '`usaha`', 200, 200, -1, false, '`usaha`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->usaha->Sortable = true; // Allow sort
        $this->usaha->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->usaha->Param, "CustomMsg");
        $this->Fields['usaha'] = &$this->usaha;

        // produk
        $this->produk = new DbField('w_users', 'w_users', 'x_produk', 'produk', '`produk`', '`produk`', 200, 200, -1, false, '`produk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->produk->Sortable = true; // Allow sort
        $this->produk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->produk->Param, "CustomMsg");
        $this->Fields['produk'] = &$this->produk;

        // last_login
        $this->last_login = new DbField('w_users', 'w_users', 'x_last_login', 'last_login', '`last_login`', CastDateFieldForLike("`last_login`", 0, "DB"), 135, 19, 0, false, '`last_login`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->last_login->Sortable = true; // Allow sort
        $this->last_login->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->last_login->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->last_login->Param, "CustomMsg");
        $this->Fields['last_login'] = &$this->last_login;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`w_users`";
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
            if (Config("ENCRYPTED_PASSWORD") && $name == Config("LOGIN_PASSWORD_FIELD_NAME")) {
                $value = Config("CASE_SENSITIVE_PASSWORD") ? EncryptPassword($value) : EncryptPassword(strtolower($value));
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
            $this->user_id->setDbValue($conn->lastInsertId());
            $rs['user_id'] = $this->user_id->DbValue;
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
            if (Config("ENCRYPTED_PASSWORD") && $name == Config("LOGIN_PASSWORD_FIELD_NAME")) {
                if ($value == $this->Fields[$name]->OldValue) { // No need to update hashed password if not changed
                    continue;
                }
                $value = Config("CASE_SENSITIVE_PASSWORD") ? EncryptPassword($value) : EncryptPassword(strtolower($value));
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
            if (array_key_exists('user_id', $rs)) {
                AddFilter($where, QuotedName('user_id', $this->Dbid) . '=' . QuotedValue($rs['user_id'], $this->user_id->DataType, $this->Dbid));
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
        $this->user_id->DbValue = $row['user_id'];
        $this->user_email->DbValue = $row['user_email'];
        $this->no_hp->DbValue = $row['no_hp'];
        $this->pass->DbValue = $row['pass'];
        $this->_userlevel->DbValue = $row['userlevel'];
        $this->aktif->DbValue = $row['aktif'];
        $this->created_at->DbValue = $row['created_at'];
        $this->user_created_by->DbValue = $row['user_created_by'];
        $this->updated_at->DbValue = $row['updated_at'];
        $this->user_updated_by->DbValue = $row['user_updated_by'];
        $this->nama_peserta->DbValue = $row['nama_peserta'];
        $this->perusahaan->DbValue = $row['perusahaan'];
        $this->jabatan->DbValue = $row['jabatan'];
        $this->provinsi->DbValue = $row['provinsi'];
        $this->kota->DbValue = $row['kota'];
        $this->usaha->DbValue = $row['usaha'];
        $this->produk->DbValue = $row['produk'];
        $this->last_login->DbValue = $row['last_login'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`user_id` = @user_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->user_id->CurrentValue : $this->user_id->OldValue;
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
                $this->user_id->CurrentValue = $keys[0];
            } else {
                $this->user_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('user_id', $row) ? $row['user_id'] : null;
        } else {
            $val = $this->user_id->OldValue !== null ? $this->user_id->OldValue : $this->user_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@user_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("wuserslist");
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
        if ($pageName == "wusersview") {
            return $Language->phrase("View");
        } elseif ($pageName == "wusersedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "wusersadd") {
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
                return "WUsersView";
            case Config("API_ADD_ACTION"):
                return "WUsersAdd";
            case Config("API_EDIT_ACTION"):
                return "WUsersEdit";
            case Config("API_DELETE_ACTION"):
                return "WUsersDelete";
            case Config("API_LIST_ACTION"):
                return "WUsersList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "wuserslist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("wusersview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("wusersview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "wusersadd?" . $this->getUrlParm($parm);
        } else {
            $url = "wusersadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("wusersedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("wusersadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("wusersdelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "user_id:" . JsonEncode($this->user_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->user_id->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->user_id->CurrentValue);
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
            if (($keyValue = Param("user_id") ?? Route("user_id")) !== null) {
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
                $this->user_id->CurrentValue = $key;
            } else {
                $this->user_id->OldValue = $key;
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
        $this->user_id->setDbValue($row['user_id']);
        $this->user_email->setDbValue($row['user_email']);
        $this->no_hp->setDbValue($row['no_hp']);
        $this->pass->setDbValue($row['pass']);
        $this->_userlevel->setDbValue($row['userlevel']);
        $this->aktif->setDbValue($row['aktif']);
        $this->created_at->setDbValue($row['created_at']);
        $this->user_created_by->setDbValue($row['user_created_by']);
        $this->updated_at->setDbValue($row['updated_at']);
        $this->user_updated_by->setDbValue($row['user_updated_by']);
        $this->nama_peserta->setDbValue($row['nama_peserta']);
        $this->perusahaan->setDbValue($row['perusahaan']);
        $this->jabatan->setDbValue($row['jabatan']);
        $this->provinsi->setDbValue($row['provinsi']);
        $this->kota->setDbValue($row['kota']);
        $this->usaha->setDbValue($row['usaha']);
        $this->produk->setDbValue($row['produk']);
        $this->last_login->setDbValue($row['last_login']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // user_id

        // user_email

        // no_hp

        // pass

        // userlevel

        // aktif

        // created_at

        // user_created_by

        // updated_at

        // user_updated_by

        // nama_peserta

        // perusahaan

        // jabatan

        // provinsi

        // kota

        // usaha

        // produk

        // last_login

        // user_id
        $this->user_id->ViewValue = $this->user_id->CurrentValue;
        $this->user_id->ViewCustomAttributes = "";

        // user_email
        $this->user_email->ViewValue = $this->user_email->CurrentValue;
        $this->user_email->ViewCustomAttributes = "";

        // no_hp
        $this->no_hp->ViewValue = $this->no_hp->CurrentValue;
        $this->no_hp->ViewCustomAttributes = "";

        // pass
        $curVal = trim(strval($this->pass->CurrentValue));
        if ($curVal != "") {
            $this->pass->ViewValue = $this->pass->lookupCacheOption($curVal);
            if ($this->pass->ViewValue === null) { // Lookup from database
                $filterWrk = "`userlevelid`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->pass->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->pass->Lookup->renderViewRow($rswrk[0]);
                    $this->pass->ViewValue = $this->pass->displayValue($arwrk);
                } else {
                    $this->pass->ViewValue = $this->pass->CurrentValue;
                }
            }
        } else {
            $this->pass->ViewValue = null;
        }
        $this->pass->ViewCustomAttributes = "";

        // userlevel
        if ($Security->canAdmin()) { // System admin
            $curVal = trim(strval($this->_userlevel->CurrentValue));
            if ($curVal != "") {
                $this->_userlevel->ViewValue = $this->_userlevel->lookupCacheOption($curVal);
                if ($this->_userlevel->ViewValue === null) { // Lookup from database
                    $filterWrk = "`userlevelid`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->_userlevel->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->_userlevel->Lookup->renderViewRow($rswrk[0]);
                        $this->_userlevel->ViewValue = $this->_userlevel->displayValue($arwrk);
                    } else {
                        $this->_userlevel->ViewValue = $this->_userlevel->CurrentValue;
                    }
                }
            } else {
                $this->_userlevel->ViewValue = null;
            }
        } else {
            $this->_userlevel->ViewValue = $Language->phrase("PasswordMask");
        }
        $this->_userlevel->ViewCustomAttributes = "";

        // aktif
        if (ConvertToBool($this->aktif->CurrentValue)) {
            $this->aktif->ViewValue = $this->aktif->tagCaption(1) != "" ? $this->aktif->tagCaption(1) : "Y";
        } else {
            $this->aktif->ViewValue = $this->aktif->tagCaption(2) != "" ? $this->aktif->tagCaption(2) : "N";
        }
        $this->aktif->ViewCustomAttributes = "";

        // created_at
        $this->created_at->ViewValue = $this->created_at->CurrentValue;
        $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
        $this->created_at->ViewCustomAttributes = "";

        // user_created_by
        $this->user_created_by->ViewValue = $this->user_created_by->CurrentValue;
        $this->user_created_by->ViewCustomAttributes = "";

        // updated_at
        $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
        $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
        $this->updated_at->ViewCustomAttributes = "";

        // user_updated_by
        $this->user_updated_by->ViewValue = $this->user_updated_by->CurrentValue;
        $this->user_updated_by->ViewCustomAttributes = "";

        // nama_peserta
        $this->nama_peserta->ViewValue = $this->nama_peserta->CurrentValue;
        $this->nama_peserta->ViewCustomAttributes = "";

        // perusahaan
        $this->perusahaan->ViewValue = $this->perusahaan->CurrentValue;
        $this->perusahaan->ViewCustomAttributes = "";

        // jabatan
        $this->jabatan->ViewValue = $this->jabatan->CurrentValue;
        $this->jabatan->ViewCustomAttributes = "";

        // provinsi
        $this->provinsi->ViewValue = $this->provinsi->CurrentValue;
        $this->provinsi->ViewValue = FormatNumber($this->provinsi->ViewValue, 0, -2, -2, -2);
        $this->provinsi->ViewCustomAttributes = "";

        // kota
        $this->kota->ViewValue = $this->kota->CurrentValue;
        $this->kota->ViewValue = FormatNumber($this->kota->ViewValue, 0, -2, -2, -2);
        $this->kota->ViewCustomAttributes = "";

        // usaha
        $this->usaha->ViewValue = $this->usaha->CurrentValue;
        $this->usaha->ViewCustomAttributes = "";

        // produk
        $this->produk->ViewValue = $this->produk->CurrentValue;
        $this->produk->ViewCustomAttributes = "";

        // last_login
        $this->last_login->ViewValue = $this->last_login->CurrentValue;
        $this->last_login->ViewValue = FormatDateTime($this->last_login->ViewValue, 0);
        $this->last_login->ViewCustomAttributes = "";

        // user_id
        $this->user_id->LinkCustomAttributes = "";
        $this->user_id->HrefValue = "";
        $this->user_id->TooltipValue = "";

        // user_email
        $this->user_email->LinkCustomAttributes = "";
        $this->user_email->HrefValue = "";
        $this->user_email->TooltipValue = "";

        // no_hp
        $this->no_hp->LinkCustomAttributes = "";
        $this->no_hp->HrefValue = "";
        $this->no_hp->TooltipValue = "";

        // pass
        $this->pass->LinkCustomAttributes = "";
        $this->pass->HrefValue = "";
        $this->pass->TooltipValue = "";

        // userlevel
        $this->_userlevel->LinkCustomAttributes = "";
        $this->_userlevel->HrefValue = "";
        $this->_userlevel->TooltipValue = "";

        // aktif
        $this->aktif->LinkCustomAttributes = "";
        $this->aktif->HrefValue = "";
        $this->aktif->TooltipValue = "";

        // created_at
        $this->created_at->LinkCustomAttributes = "";
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

        // user_created_by
        $this->user_created_by->LinkCustomAttributes = "";
        $this->user_created_by->HrefValue = "";
        $this->user_created_by->TooltipValue = "";

        // updated_at
        $this->updated_at->LinkCustomAttributes = "";
        $this->updated_at->HrefValue = "";
        $this->updated_at->TooltipValue = "";

        // user_updated_by
        $this->user_updated_by->LinkCustomAttributes = "";
        $this->user_updated_by->HrefValue = "";
        $this->user_updated_by->TooltipValue = "";

        // nama_peserta
        $this->nama_peserta->LinkCustomAttributes = "";
        $this->nama_peserta->HrefValue = "";
        $this->nama_peserta->TooltipValue = "";

        // perusahaan
        $this->perusahaan->LinkCustomAttributes = "";
        $this->perusahaan->HrefValue = "";
        $this->perusahaan->TooltipValue = "";

        // jabatan
        $this->jabatan->LinkCustomAttributes = "";
        $this->jabatan->HrefValue = "";
        $this->jabatan->TooltipValue = "";

        // provinsi
        $this->provinsi->LinkCustomAttributes = "";
        $this->provinsi->HrefValue = "";
        $this->provinsi->TooltipValue = "";

        // kota
        $this->kota->LinkCustomAttributes = "";
        $this->kota->HrefValue = "";
        $this->kota->TooltipValue = "";

        // usaha
        $this->usaha->LinkCustomAttributes = "";
        $this->usaha->HrefValue = "";
        $this->usaha->TooltipValue = "";

        // produk
        $this->produk->LinkCustomAttributes = "";
        $this->produk->HrefValue = "";
        $this->produk->TooltipValue = "";

        // last_login
        $this->last_login->LinkCustomAttributes = "";
        $this->last_login->HrefValue = "";
        $this->last_login->TooltipValue = "";

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

        // user_id
        $this->user_id->EditAttrs["class"] = "form-control";
        $this->user_id->EditCustomAttributes = "";
        $this->user_id->EditValue = $this->user_id->CurrentValue;
        $this->user_id->ViewCustomAttributes = "";

        // user_email
        $this->user_email->EditAttrs["class"] = "form-control";
        $this->user_email->EditCustomAttributes = "";
        if (!$this->user_email->Raw) {
            $this->user_email->CurrentValue = HtmlDecode($this->user_email->CurrentValue);
        }
        $this->user_email->EditValue = $this->user_email->CurrentValue;
        $this->user_email->PlaceHolder = RemoveHtml($this->user_email->caption());

        // no_hp
        $this->no_hp->EditAttrs["class"] = "form-control";
        $this->no_hp->EditCustomAttributes = "";
        if (!$this->no_hp->Raw) {
            $this->no_hp->CurrentValue = HtmlDecode($this->no_hp->CurrentValue);
        }
        $this->no_hp->EditValue = $this->no_hp->CurrentValue;
        $this->no_hp->PlaceHolder = RemoveHtml($this->no_hp->caption());

        // pass
        $this->pass->EditAttrs["class"] = "form-control";
        $this->pass->EditCustomAttributes = "";
        $this->pass->PlaceHolder = RemoveHtml($this->pass->caption());

        // userlevel
        $this->_userlevel->EditAttrs["class"] = "form-control";
        $this->_userlevel->EditCustomAttributes = "";
        if (!$Security->canAdmin()) { // System admin
            $this->_userlevel->EditValue = $Language->phrase("PasswordMask");
        } else {
            $this->_userlevel->PlaceHolder = RemoveHtml($this->_userlevel->caption());
        }

        // aktif
        $this->aktif->EditCustomAttributes = "";
        $this->aktif->EditValue = $this->aktif->options(false);
        $this->aktif->PlaceHolder = RemoveHtml($this->aktif->caption());

        // created_at

        // user_created_by

        // updated_at

        // user_updated_by

        // nama_peserta
        $this->nama_peserta->EditAttrs["class"] = "form-control";
        $this->nama_peserta->EditCustomAttributes = "";
        if (!$this->nama_peserta->Raw) {
            $this->nama_peserta->CurrentValue = HtmlDecode($this->nama_peserta->CurrentValue);
        }
        $this->nama_peserta->EditValue = $this->nama_peserta->CurrentValue;
        $this->nama_peserta->PlaceHolder = RemoveHtml($this->nama_peserta->caption());

        // perusahaan
        $this->perusahaan->EditAttrs["class"] = "form-control";
        $this->perusahaan->EditCustomAttributes = "";
        if (!$this->perusahaan->Raw) {
            $this->perusahaan->CurrentValue = HtmlDecode($this->perusahaan->CurrentValue);
        }
        $this->perusahaan->EditValue = $this->perusahaan->CurrentValue;
        $this->perusahaan->PlaceHolder = RemoveHtml($this->perusahaan->caption());

        // jabatan
        $this->jabatan->EditAttrs["class"] = "form-control";
        $this->jabatan->EditCustomAttributes = "";
        if (!$this->jabatan->Raw) {
            $this->jabatan->CurrentValue = HtmlDecode($this->jabatan->CurrentValue);
        }
        $this->jabatan->EditValue = $this->jabatan->CurrentValue;
        $this->jabatan->PlaceHolder = RemoveHtml($this->jabatan->caption());

        // provinsi
        $this->provinsi->EditAttrs["class"] = "form-control";
        $this->provinsi->EditCustomAttributes = "";
        $this->provinsi->EditValue = $this->provinsi->CurrentValue;
        $this->provinsi->PlaceHolder = RemoveHtml($this->provinsi->caption());

        // kota
        $this->kota->EditAttrs["class"] = "form-control";
        $this->kota->EditCustomAttributes = "";
        $this->kota->EditValue = $this->kota->CurrentValue;
        $this->kota->PlaceHolder = RemoveHtml($this->kota->caption());

        // usaha
        $this->usaha->EditAttrs["class"] = "form-control";
        $this->usaha->EditCustomAttributes = "";
        if (!$this->usaha->Raw) {
            $this->usaha->CurrentValue = HtmlDecode($this->usaha->CurrentValue);
        }
        $this->usaha->EditValue = $this->usaha->CurrentValue;
        $this->usaha->PlaceHolder = RemoveHtml($this->usaha->caption());

        // produk
        $this->produk->EditAttrs["class"] = "form-control";
        $this->produk->EditCustomAttributes = "";
        if (!$this->produk->Raw) {
            $this->produk->CurrentValue = HtmlDecode($this->produk->CurrentValue);
        }
        $this->produk->EditValue = $this->produk->CurrentValue;
        $this->produk->PlaceHolder = RemoveHtml($this->produk->caption());

        // last_login
        $this->last_login->EditAttrs["class"] = "form-control";
        $this->last_login->EditCustomAttributes = "";
        $this->last_login->EditValue = FormatDateTime($this->last_login->CurrentValue, 8);
        $this->last_login->PlaceHolder = RemoveHtml($this->last_login->caption());

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
                    $doc->exportCaption($this->user_id);
                    $doc->exportCaption($this->user_email);
                    $doc->exportCaption($this->no_hp);
                    $doc->exportCaption($this->pass);
                    $doc->exportCaption($this->_userlevel);
                    $doc->exportCaption($this->aktif);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->user_created_by);
                    $doc->exportCaption($this->updated_at);
                    $doc->exportCaption($this->user_updated_by);
                    $doc->exportCaption($this->nama_peserta);
                    $doc->exportCaption($this->perusahaan);
                    $doc->exportCaption($this->jabatan);
                    $doc->exportCaption($this->provinsi);
                    $doc->exportCaption($this->kota);
                    $doc->exportCaption($this->usaha);
                    $doc->exportCaption($this->produk);
                    $doc->exportCaption($this->last_login);
                } else {
                    $doc->exportCaption($this->user_id);
                    $doc->exportCaption($this->user_email);
                    $doc->exportCaption($this->no_hp);
                    $doc->exportCaption($this->_userlevel);
                    $doc->exportCaption($this->aktif);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->user_created_by);
                    $doc->exportCaption($this->updated_at);
                    $doc->exportCaption($this->user_updated_by);
                    $doc->exportCaption($this->nama_peserta);
                    $doc->exportCaption($this->perusahaan);
                    $doc->exportCaption($this->jabatan);
                    $doc->exportCaption($this->provinsi);
                    $doc->exportCaption($this->kota);
                    $doc->exportCaption($this->usaha);
                    $doc->exportCaption($this->produk);
                    $doc->exportCaption($this->last_login);
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
                        $doc->exportField($this->user_id);
                        $doc->exportField($this->user_email);
                        $doc->exportField($this->no_hp);
                        $doc->exportField($this->pass);
                        $doc->exportField($this->_userlevel);
                        $doc->exportField($this->aktif);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->user_created_by);
                        $doc->exportField($this->updated_at);
                        $doc->exportField($this->user_updated_by);
                        $doc->exportField($this->nama_peserta);
                        $doc->exportField($this->perusahaan);
                        $doc->exportField($this->jabatan);
                        $doc->exportField($this->provinsi);
                        $doc->exportField($this->kota);
                        $doc->exportField($this->usaha);
                        $doc->exportField($this->produk);
                        $doc->exportField($this->last_login);
                    } else {
                        $doc->exportField($this->user_id);
                        $doc->exportField($this->user_email);
                        $doc->exportField($this->no_hp);
                        $doc->exportField($this->_userlevel);
                        $doc->exportField($this->aktif);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->user_created_by);
                        $doc->exportField($this->updated_at);
                        $doc->exportField($this->user_updated_by);
                        $doc->exportField($this->nama_peserta);
                        $doc->exportField($this->perusahaan);
                        $doc->exportField($this->jabatan);
                        $doc->exportField($this->provinsi);
                        $doc->exportField($this->kota);
                        $doc->exportField($this->usaha);
                        $doc->exportField($this->produk);
                        $doc->exportField($this->last_login);
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
        // No binary fields
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
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
