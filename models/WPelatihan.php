<?php

namespace PHPMaker2021\ppejp_web;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for w_pelatihan
 */
class WPelatihan extends DbTable
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
    public $pelatihan_id;
    public $jenis_pelatihan;
    public $judul_pelatihan;
    public $jumlah_hari;
    public $tempat;
    public $jumlah_peserta;
    public $sisa;
    public $harga;
    public $tawal;
    public $takhir;
    public $tanggal_pelaksanaan;
    public $gambar;
    public $kategori;
    public $tujuan;
    public $sub_kategori;
    public $topik_bahasan;
    public $catatan;
    public $Link;
    public $Last_Updated;
    public $Created_Date;
    public $Activated;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'w_pelatihan';
        $this->TableName = 'w_pelatihan';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`w_pelatihan`";
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

        // pelatihan_id
        $this->pelatihan_id = new DbField('w_pelatihan', 'w_pelatihan', 'x_pelatihan_id', 'pelatihan_id', '`pelatihan_id`', '`pelatihan_id`', 3, 9, -1, false, '`pelatihan_id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->pelatihan_id->IsAutoIncrement = true; // Autoincrement field
        $this->pelatihan_id->IsPrimaryKey = true; // Primary key field
        $this->pelatihan_id->Sortable = true; // Allow sort
        $this->pelatihan_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->pelatihan_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pelatihan_id->Param, "CustomMsg");
        $this->Fields['pelatihan_id'] = &$this->pelatihan_id;

        // jenis_pelatihan
        $this->jenis_pelatihan = new DbField('w_pelatihan', 'w_pelatihan', 'x_jenis_pelatihan', 'jenis_pelatihan', '`jenis_pelatihan`', '`jenis_pelatihan`', 200, 25, -1, false, '`jenis_pelatihan`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->jenis_pelatihan->Nullable = false; // NOT NULL field
        $this->jenis_pelatihan->Required = true; // Required field
        $this->jenis_pelatihan->Sortable = true; // Allow sort
        $this->jenis_pelatihan->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->jenis_pelatihan->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->jenis_pelatihan->Lookup = new Lookup('jenis_pelatihan', 'w_pelatihan', false, '', ["","","",""], [], [], [], [], [], [], '', '');
        $this->jenis_pelatihan->OptionCount = 8;
        $this->jenis_pelatihan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jenis_pelatihan->Param, "CustomMsg");
        $this->Fields['jenis_pelatihan'] = &$this->jenis_pelatihan;

        // judul_pelatihan
        $this->judul_pelatihan = new DbField('w_pelatihan', 'w_pelatihan', 'x_judul_pelatihan', 'judul_pelatihan', '`judul_pelatihan`', '`judul_pelatihan`', 200, 255, -1, false, '`judul_pelatihan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->judul_pelatihan->Nullable = false; // NOT NULL field
        $this->judul_pelatihan->Required = true; // Required field
        $this->judul_pelatihan->Sortable = true; // Allow sort
        $this->judul_pelatihan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->judul_pelatihan->Param, "CustomMsg");
        $this->Fields['judul_pelatihan'] = &$this->judul_pelatihan;

        // jumlah_hari
        $this->jumlah_hari = new DbField('w_pelatihan', 'w_pelatihan', 'x_jumlah_hari', 'jumlah_hari', '`jumlah_hari`', '`jumlah_hari`', 200, 25, -1, false, '`jumlah_hari`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jumlah_hari->Nullable = false; // NOT NULL field
        $this->jumlah_hari->Required = true; // Required field
        $this->jumlah_hari->Sortable = true; // Allow sort
        $this->jumlah_hari->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jumlah_hari->Param, "CustomMsg");
        $this->Fields['jumlah_hari'] = &$this->jumlah_hari;

        // tempat
        $this->tempat = new DbField('w_pelatihan', 'w_pelatihan', 'x_tempat', 'tempat', '`tempat`', '`tempat`', 200, 100, -1, false, '`tempat`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tempat->Nullable = false; // NOT NULL field
        $this->tempat->Required = true; // Required field
        $this->tempat->Sortable = true; // Allow sort
        $this->tempat->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tempat->Param, "CustomMsg");
        $this->Fields['tempat'] = &$this->tempat;

        // jumlah_peserta
        $this->jumlah_peserta = new DbField('w_pelatihan', 'w_pelatihan', 'x_jumlah_peserta', 'jumlah_peserta', '`jumlah_peserta`', '`jumlah_peserta`', 16, 4, -1, false, '`jumlah_peserta`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jumlah_peserta->Nullable = false; // NOT NULL field
        $this->jumlah_peserta->Required = true; // Required field
        $this->jumlah_peserta->Sortable = true; // Allow sort
        $this->jumlah_peserta->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->jumlah_peserta->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jumlah_peserta->Param, "CustomMsg");
        $this->Fields['jumlah_peserta'] = &$this->jumlah_peserta;

        // sisa
        $this->sisa = new DbField('w_pelatihan', 'w_pelatihan', 'x_sisa', 'sisa', '`sisa`', '`sisa`', 16, 4, -1, false, '`sisa`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->sisa->Nullable = false; // NOT NULL field
        $this->sisa->Required = true; // Required field
        $this->sisa->Sortable = true; // Allow sort
        $this->sisa->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->sisa->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sisa->Param, "CustomMsg");
        $this->Fields['sisa'] = &$this->sisa;

        // harga
        $this->harga = new DbField('w_pelatihan', 'w_pelatihan', 'x_harga', 'harga', '`harga`', '`harga`', 131, 10, -1, false, '`harga`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->harga->Nullable = false; // NOT NULL field
        $this->harga->Required = true; // Required field
        $this->harga->Sortable = true; // Allow sort
        $this->harga->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->harga->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->harga->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->harga->Param, "CustomMsg");
        $this->Fields['harga'] = &$this->harga;

        // tawal
        $this->tawal = new DbField('w_pelatihan', 'w_pelatihan', 'x_tawal', 'tawal', '`tawal`', CastDateFieldForLike("`tawal`", 7, "DB"), 135, 19, 7, false, '`tawal`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tawal->Required = true; // Required field
        $this->tawal->Sortable = true; // Allow sort
        $this->tawal->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
        $this->tawal->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tawal->Param, "CustomMsg");
        $this->Fields['tawal'] = &$this->tawal;

        // takhir
        $this->takhir = new DbField('w_pelatihan', 'w_pelatihan', 'x_takhir', 'takhir', '`takhir`', CastDateFieldForLike("`takhir`", 7, "DB"), 135, 19, 7, false, '`takhir`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->takhir->Required = true; // Required field
        $this->takhir->Sortable = true; // Allow sort
        $this->takhir->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
        $this->takhir->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->takhir->Param, "CustomMsg");
        $this->Fields['takhir'] = &$this->takhir;

        // tanggal_pelaksanaan
        $this->tanggal_pelaksanaan = new DbField('w_pelatihan', 'w_pelatihan', 'x_tanggal_pelaksanaan', 'tanggal_pelaksanaan', '`tanggal_pelaksanaan`', '`tanggal_pelaksanaan`', 200, 100, -1, false, '`tanggal_pelaksanaan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tanggal_pelaksanaan->Nullable = false; // NOT NULL field
        $this->tanggal_pelaksanaan->Required = true; // Required field
        $this->tanggal_pelaksanaan->Sortable = true; // Allow sort
        $this->tanggal_pelaksanaan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal_pelaksanaan->Param, "CustomMsg");
        $this->Fields['tanggal_pelaksanaan'] = &$this->tanggal_pelaksanaan;

        // gambar
        $this->gambar = new DbField('w_pelatihan', 'w_pelatihan', 'x_gambar', 'gambar', '`gambar`', '`gambar`', 200, 255, -1, true, '`gambar`', false, false, false, 'IMAGE', 'FILE');
        $this->gambar->Nullable = false; // NOT NULL field
        $this->gambar->Required = true; // Required field
        $this->gambar->Sortable = true; // Allow sort
        $this->gambar->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->gambar->Param, "CustomMsg");
        $this->Fields['gambar'] = &$this->gambar;

        // kategori
        $this->kategori = new DbField('w_pelatihan', 'w_pelatihan', 'x_kategori', 'kategori', '`kategori`', '`kategori`', 200, 100, -1, false, '`kategori`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kategori->Nullable = false; // NOT NULL field
        $this->kategori->Required = true; // Required field
        $this->kategori->Sortable = true; // Allow sort
        $this->kategori->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kategori->Param, "CustomMsg");
        $this->Fields['kategori'] = &$this->kategori;

        // tujuan
        $this->tujuan = new DbField('w_pelatihan', 'w_pelatihan', 'x_tujuan', 'tujuan', '`tujuan`', '`tujuan`', 201, 65535, -1, false, '`tujuan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->tujuan->Sortable = true; // Allow sort
        $this->tujuan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tujuan->Param, "CustomMsg");
        $this->Fields['tujuan'] = &$this->tujuan;

        // sub_kategori
        $this->sub_kategori = new DbField('w_pelatihan', 'w_pelatihan', 'x_sub_kategori', 'sub_kategori', '`sub_kategori`', '`sub_kategori`', 200, 150, -1, false, '`sub_kategori`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->sub_kategori->Nullable = false; // NOT NULL field
        $this->sub_kategori->Required = true; // Required field
        $this->sub_kategori->Sortable = true; // Allow sort
        $this->sub_kategori->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sub_kategori->Param, "CustomMsg");
        $this->Fields['sub_kategori'] = &$this->sub_kategori;

        // topik_bahasan
        $this->topik_bahasan = new DbField('w_pelatihan', 'w_pelatihan', 'x_topik_bahasan', 'topik_bahasan', '`topik_bahasan`', '`topik_bahasan`', 201, 65535, -1, false, '`topik_bahasan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->topik_bahasan->Nullable = false; // NOT NULL field
        $this->topik_bahasan->Required = true; // Required field
        $this->topik_bahasan->Sortable = true; // Allow sort
        $this->topik_bahasan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->topik_bahasan->Param, "CustomMsg");
        $this->Fields['topik_bahasan'] = &$this->topik_bahasan;

        // catatan
        $this->catatan = new DbField('w_pelatihan', 'w_pelatihan', 'x_catatan', 'catatan', '`catatan`', '`catatan`', 201, 65535, -1, false, '`catatan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->catatan->Sortable = true; // Allow sort
        $this->catatan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->catatan->Param, "CustomMsg");
        $this->Fields['catatan'] = &$this->catatan;

        // Link
        $this->Link = new DbField('w_pelatihan', 'w_pelatihan', 'x_Link', 'Link', '`Link`', '`Link`', 201, 65535, -1, false, '`Link`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->Link->Sortable = true; // Allow sort
        $this->Link->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Link->Param, "CustomMsg");
        $this->Fields['Link'] = &$this->Link;

        // Last_Updated
        $this->Last_Updated = new DbField('w_pelatihan', 'w_pelatihan', 'x_Last_Updated', 'Last_Updated', '`Last_Updated`', CastDateFieldForLike("`Last_Updated`", 0, "DB"), 135, 19, 0, false, '`Last_Updated`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Last_Updated->Nullable = false; // NOT NULL field
        $this->Last_Updated->Sortable = true; // Allow sort
        $this->Last_Updated->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Last_Updated->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Last_Updated->Param, "CustomMsg");
        $this->Fields['Last_Updated'] = &$this->Last_Updated;

        // Created_Date
        $this->Created_Date = new DbField('w_pelatihan', 'w_pelatihan', 'x_Created_Date', 'Created_Date', '`Created_Date`', CastDateFieldForLike("`Created_Date`", 0, "DB"), 135, 19, 0, false, '`Created_Date`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Created_Date->Nullable = false; // NOT NULL field
        $this->Created_Date->Sortable = true; // Allow sort
        $this->Created_Date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Created_Date->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Created_Date->Param, "CustomMsg");
        $this->Fields['Created_Date'] = &$this->Created_Date;

        // Activated
        $this->Activated = new DbField('w_pelatihan', 'w_pelatihan', 'x_Activated', 'Activated', '`Activated`', '`Activated`', 202, 1, -1, false, '`Activated`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->Activated->Sortable = true; // Allow sort
        $this->Activated->DataType = DATATYPE_BOOLEAN;
        $this->Activated->TrueValue = "Y";
        $this->Activated->FalseValue = "N";
        $this->Activated->Lookup = new Lookup('Activated', 'w_pelatihan', false, '', ["","","",""], [], [], [], [], [], [], '', '');
        $this->Activated->OptionCount = 2;
        $this->Activated->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Activated->Param, "CustomMsg");
        $this->Fields['Activated'] = &$this->Activated;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`w_pelatihan`";
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
            $this->pelatihan_id->setDbValue($conn->lastInsertId());
            $rs['pelatihan_id'] = $this->pelatihan_id->DbValue;
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
            if (array_key_exists('pelatihan_id', $rs)) {
                AddFilter($where, QuotedName('pelatihan_id', $this->Dbid) . '=' . QuotedValue($rs['pelatihan_id'], $this->pelatihan_id->DataType, $this->Dbid));
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
        $this->pelatihan_id->DbValue = $row['pelatihan_id'];
        $this->jenis_pelatihan->DbValue = $row['jenis_pelatihan'];
        $this->judul_pelatihan->DbValue = $row['judul_pelatihan'];
        $this->jumlah_hari->DbValue = $row['jumlah_hari'];
        $this->tempat->DbValue = $row['tempat'];
        $this->jumlah_peserta->DbValue = $row['jumlah_peserta'];
        $this->sisa->DbValue = $row['sisa'];
        $this->harga->DbValue = $row['harga'];
        $this->tawal->DbValue = $row['tawal'];
        $this->takhir->DbValue = $row['takhir'];
        $this->tanggal_pelaksanaan->DbValue = $row['tanggal_pelaksanaan'];
        $this->gambar->Upload->DbValue = $row['gambar'];
        $this->kategori->DbValue = $row['kategori'];
        $this->tujuan->DbValue = $row['tujuan'];
        $this->sub_kategori->DbValue = $row['sub_kategori'];
        $this->topik_bahasan->DbValue = $row['topik_bahasan'];
        $this->catatan->DbValue = $row['catatan'];
        $this->Link->DbValue = $row['Link'];
        $this->Last_Updated->DbValue = $row['Last_Updated'];
        $this->Created_Date->DbValue = $row['Created_Date'];
        $this->Activated->DbValue = $row['Activated'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
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
        return "`pelatihan_id` = @pelatihan_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->pelatihan_id->CurrentValue : $this->pelatihan_id->OldValue;
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
                $this->pelatihan_id->CurrentValue = $keys[0];
            } else {
                $this->pelatihan_id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('pelatihan_id', $row) ? $row['pelatihan_id'] : null;
        } else {
            $val = $this->pelatihan_id->OldValue !== null ? $this->pelatihan_id->OldValue : $this->pelatihan_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@pelatihan_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("wpelatihanlist");
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
        if ($pageName == "wpelatihanview") {
            return $Language->phrase("View");
        } elseif ($pageName == "wpelatihanedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "wpelatihanadd") {
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
                return "WPelatihanView";
            case Config("API_ADD_ACTION"):
                return "WPelatihanAdd";
            case Config("API_EDIT_ACTION"):
                return "WPelatihanEdit";
            case Config("API_DELETE_ACTION"):
                return "WPelatihanDelete";
            case Config("API_LIST_ACTION"):
                return "WPelatihanList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "wpelatihanlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("wpelatihanview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("wpelatihanview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "wpelatihanadd?" . $this->getUrlParm($parm);
        } else {
            $url = "wpelatihanadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("wpelatihanedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("wpelatihanadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("wpelatihandelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "pelatihan_id:" . JsonEncode($this->pelatihan_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->pelatihan_id->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->pelatihan_id->CurrentValue);
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
            if (($keyValue = Param("pelatihan_id") ?? Route("pelatihan_id")) !== null) {
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
                $this->pelatihan_id->CurrentValue = $key;
            } else {
                $this->pelatihan_id->OldValue = $key;
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

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

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

        // pelatihan_id
        $this->pelatihan_id->EditAttrs["class"] = "form-control";
        $this->pelatihan_id->EditCustomAttributes = "";
        $this->pelatihan_id->EditValue = $this->pelatihan_id->CurrentValue;
        $this->pelatihan_id->ViewCustomAttributes = "";

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
        $this->judul_pelatihan->EditValue = $this->judul_pelatihan->CurrentValue;
        $this->judul_pelatihan->PlaceHolder = RemoveHtml($this->judul_pelatihan->caption());

        // jumlah_hari
        $this->jumlah_hari->EditAttrs["class"] = "form-control";
        $this->jumlah_hari->EditCustomAttributes = "";
        if (!$this->jumlah_hari->Raw) {
            $this->jumlah_hari->CurrentValue = HtmlDecode($this->jumlah_hari->CurrentValue);
        }
        $this->jumlah_hari->EditValue = $this->jumlah_hari->CurrentValue;
        $this->jumlah_hari->PlaceHolder = RemoveHtml($this->jumlah_hari->caption());

        // tempat
        $this->tempat->EditAttrs["class"] = "form-control";
        $this->tempat->EditCustomAttributes = "";
        if (!$this->tempat->Raw) {
            $this->tempat->CurrentValue = HtmlDecode($this->tempat->CurrentValue);
        }
        $this->tempat->EditValue = $this->tempat->CurrentValue;
        $this->tempat->PlaceHolder = RemoveHtml($this->tempat->caption());

        // jumlah_peserta
        $this->jumlah_peserta->EditAttrs["class"] = "form-control";
        $this->jumlah_peserta->EditCustomAttributes = "";
        $this->jumlah_peserta->EditValue = $this->jumlah_peserta->CurrentValue;
        $this->jumlah_peserta->PlaceHolder = RemoveHtml($this->jumlah_peserta->caption());

        // sisa
        $this->sisa->EditAttrs["class"] = "form-control";
        $this->sisa->EditCustomAttributes = "";
        $this->sisa->EditValue = $this->sisa->CurrentValue;
        $this->sisa->PlaceHolder = RemoveHtml($this->sisa->caption());

        // harga
        $this->harga->EditAttrs["class"] = "form-control";
        $this->harga->EditCustomAttributes = "";
        $this->harga->EditValue = $this->harga->CurrentValue;
        $this->harga->PlaceHolder = RemoveHtml($this->harga->caption());
        if (strval($this->harga->EditValue) != "" && is_numeric($this->harga->EditValue)) {
            $this->harga->EditValue = FormatNumber($this->harga->EditValue, -2, -2, -2, -2);
        }

        // tawal
        $this->tawal->EditAttrs["class"] = "form-control";
        $this->tawal->EditCustomAttributes = "";
        $this->tawal->EditValue = FormatDateTime($this->tawal->CurrentValue, 7);
        $this->tawal->PlaceHolder = RemoveHtml($this->tawal->caption());

        // takhir
        $this->takhir->EditAttrs["class"] = "form-control";
        $this->takhir->EditCustomAttributes = "";
        $this->takhir->EditValue = FormatDateTime($this->takhir->CurrentValue, 7);
        $this->takhir->PlaceHolder = RemoveHtml($this->takhir->caption());

        // tanggal_pelaksanaan
        $this->tanggal_pelaksanaan->EditAttrs["class"] = "form-control";
        $this->tanggal_pelaksanaan->EditCustomAttributes = "";
        if (!$this->tanggal_pelaksanaan->Raw) {
            $this->tanggal_pelaksanaan->CurrentValue = HtmlDecode($this->tanggal_pelaksanaan->CurrentValue);
        }
        $this->tanggal_pelaksanaan->EditValue = $this->tanggal_pelaksanaan->CurrentValue;
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

        // kategori
        $this->kategori->EditAttrs["class"] = "form-control";
        $this->kategori->EditCustomAttributes = "";
        if (!$this->kategori->Raw) {
            $this->kategori->CurrentValue = HtmlDecode($this->kategori->CurrentValue);
        }
        $this->kategori->EditValue = $this->kategori->CurrentValue;
        $this->kategori->PlaceHolder = RemoveHtml($this->kategori->caption());

        // tujuan
        $this->tujuan->EditAttrs["class"] = "form-control";
        $this->tujuan->EditCustomAttributes = "";
        $this->tujuan->EditValue = $this->tujuan->CurrentValue;
        $this->tujuan->PlaceHolder = RemoveHtml($this->tujuan->caption());

        // sub_kategori
        $this->sub_kategori->EditAttrs["class"] = "form-control";
        $this->sub_kategori->EditCustomAttributes = "";
        if (!$this->sub_kategori->Raw) {
            $this->sub_kategori->CurrentValue = HtmlDecode($this->sub_kategori->CurrentValue);
        }
        $this->sub_kategori->EditValue = $this->sub_kategori->CurrentValue;
        $this->sub_kategori->PlaceHolder = RemoveHtml($this->sub_kategori->caption());

        // topik_bahasan
        $this->topik_bahasan->EditAttrs["class"] = "form-control";
        $this->topik_bahasan->EditCustomAttributes = "";
        $this->topik_bahasan->EditValue = $this->topik_bahasan->CurrentValue;
        $this->topik_bahasan->PlaceHolder = RemoveHtml($this->topik_bahasan->caption());

        // catatan
        $this->catatan->EditAttrs["class"] = "form-control";
        $this->catatan->EditCustomAttributes = "";
        $this->catatan->EditValue = $this->catatan->CurrentValue;
        $this->catatan->PlaceHolder = RemoveHtml($this->catatan->caption());

        // Link
        $this->Link->EditAttrs["class"] = "form-control";
        $this->Link->EditCustomAttributes = "";
        $this->Link->EditValue = $this->Link->CurrentValue;
        $this->Link->PlaceHolder = RemoveHtml($this->Link->caption());

        // Last_Updated

        // Created_Date

        // Activated
        $this->Activated->EditCustomAttributes = "";
        $this->Activated->EditValue = $this->Activated->options(false);
        $this->Activated->PlaceHolder = RemoveHtml($this->Activated->caption());

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
                    $doc->exportCaption($this->pelatihan_id);
                    $doc->exportCaption($this->jenis_pelatihan);
                    $doc->exportCaption($this->judul_pelatihan);
                    $doc->exportCaption($this->jumlah_hari);
                    $doc->exportCaption($this->tempat);
                    $doc->exportCaption($this->jumlah_peserta);
                    $doc->exportCaption($this->sisa);
                    $doc->exportCaption($this->harga);
                    $doc->exportCaption($this->tawal);
                    $doc->exportCaption($this->takhir);
                    $doc->exportCaption($this->tanggal_pelaksanaan);
                    $doc->exportCaption($this->gambar);
                    $doc->exportCaption($this->kategori);
                    $doc->exportCaption($this->tujuan);
                    $doc->exportCaption($this->sub_kategori);
                    $doc->exportCaption($this->topik_bahasan);
                    $doc->exportCaption($this->catatan);
                    $doc->exportCaption($this->Link);
                    $doc->exportCaption($this->Last_Updated);
                    $doc->exportCaption($this->Created_Date);
                    $doc->exportCaption($this->Activated);
                } else {
                    $doc->exportCaption($this->pelatihan_id);
                    $doc->exportCaption($this->jenis_pelatihan);
                    $doc->exportCaption($this->judul_pelatihan);
                    $doc->exportCaption($this->jumlah_hari);
                    $doc->exportCaption($this->tempat);
                    $doc->exportCaption($this->jumlah_peserta);
                    $doc->exportCaption($this->sisa);
                    $doc->exportCaption($this->harga);
                    $doc->exportCaption($this->tawal);
                    $doc->exportCaption($this->takhir);
                    $doc->exportCaption($this->tanggal_pelaksanaan);
                    $doc->exportCaption($this->gambar);
                    $doc->exportCaption($this->kategori);
                    $doc->exportCaption($this->sub_kategori);
                    $doc->exportCaption($this->Last_Updated);
                    $doc->exportCaption($this->Created_Date);
                    $doc->exportCaption($this->Activated);
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
                        $doc->exportField($this->pelatihan_id);
                        $doc->exportField($this->jenis_pelatihan);
                        $doc->exportField($this->judul_pelatihan);
                        $doc->exportField($this->jumlah_hari);
                        $doc->exportField($this->tempat);
                        $doc->exportField($this->jumlah_peserta);
                        $doc->exportField($this->sisa);
                        $doc->exportField($this->harga);
                        $doc->exportField($this->tawal);
                        $doc->exportField($this->takhir);
                        $doc->exportField($this->tanggal_pelaksanaan);
                        $doc->exportField($this->gambar);
                        $doc->exportField($this->kategori);
                        $doc->exportField($this->tujuan);
                        $doc->exportField($this->sub_kategori);
                        $doc->exportField($this->topik_bahasan);
                        $doc->exportField($this->catatan);
                        $doc->exportField($this->Link);
                        $doc->exportField($this->Last_Updated);
                        $doc->exportField($this->Created_Date);
                        $doc->exportField($this->Activated);
                    } else {
                        $doc->exportField($this->pelatihan_id);
                        $doc->exportField($this->jenis_pelatihan);
                        $doc->exportField($this->judul_pelatihan);
                        $doc->exportField($this->jumlah_hari);
                        $doc->exportField($this->tempat);
                        $doc->exportField($this->jumlah_peserta);
                        $doc->exportField($this->sisa);
                        $doc->exportField($this->harga);
                        $doc->exportField($this->tawal);
                        $doc->exportField($this->takhir);
                        $doc->exportField($this->tanggal_pelaksanaan);
                        $doc->exportField($this->gambar);
                        $doc->exportField($this->kategori);
                        $doc->exportField($this->sub_kategori);
                        $doc->exportField($this->Last_Updated);
                        $doc->exportField($this->Created_Date);
                        $doc->exportField($this->Activated);
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
            $this->pelatihan_id->CurrentValue = $ar[0];
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
    	$nomr = ExecuteScalar("SELECT COUNT(1) FROM `w_pelatihan` WHERE `judul_pelatihan` LIKE '".$rsnew["judul_pelatihan"]."'") + 1;
    	$nama_file_baru = str_replace(' ', '-', $rsnew["judul_pelatihan"])."_".$nomr;
    	$ext = pathinfo($rsnew["gambar"], PATHINFO_EXTENSION);
    	$rsnew["gambar"] = $nama_file_baru . "." . $ext;		
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
        $rsnew["gambar"] = $rsold["gambar"];		
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
