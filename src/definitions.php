<?php

namespace PHPMaker2021\ppejp_web;

use Slim\Views\PhpRenderer;
use Slim\Csrf\Guard;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\DebugStack;

return [
    "cache" => function (ContainerInterface $c) {
        return new \Slim\HttpCache\CacheProvider();
    },
    "view" => function (ContainerInterface $c) {
        return new PhpRenderer("views/");
    },
    "flash" => function (ContainerInterface $c) {
        return new \Slim\Flash\Messages();
    },
    "audit" => function (ContainerInterface $c) {
        $logger = new Logger("audit"); // For audit trail
        $logger->pushHandler(new AuditTrailHandler("audit.log"));
        return $logger;
    },
    "log" => function (ContainerInterface $c) {
        global $RELATIVE_PATH;
        $logger = new Logger("log");
        $logger->pushHandler(new RotatingFileHandler($RELATIVE_PATH . "log.log"));
        return $logger;
    },
    "sqllogger" => function (ContainerInterface $c) {
        $loggers = [];
        if (Config("DEBUG")) {
            $loggers[] = $c->get("debugstack");
        }
        return (count($loggers) > 0) ? new LoggerChain($loggers) : null;
    },
    "csrf" => function (ContainerInterface $c) {
        global $ResponseFactory;
        return new Guard($ResponseFactory, Config("CSRF_PREFIX"));
    },
    "debugstack" => \DI\create(DebugStack::class),
    "debugsqllogger" => \DI\create(DebugSqlLogger::class),
    "security" => \DI\create(AdvancedSecurity::class),
    "profile" => \DI\create(UserProfile::class),
    "language" => \DI\create(Language::class),
    "timer" => \DI\create(Timer::class),
    "session" => \DI\create(HttpSession::class),

    // Tables
    "w_users" => \DI\create(WUsers::class),
    "home" => \DI\create(Home::class),
    "w_pages" => \DI\create(WPages::class),
    "pelatihan" => \DI\create(Pelatihan::class),
    "exportcoachingprogram" => \DI\create(Exportcoachingprogram::class),
    "obrolanekspor" => \DI\create(Obrolanekspor::class),
    "webinar" => \DI\create(Webinar::class),
    "berita" => \DI\create(Berita::class),
    "tentangkami" => \DI\create(Tentangkami::class),
    "tentangbpmjp" => \DI\create(Tentangbpmjp::class),
    "informasipelatihan" => \DI\create(Informasipelatihan::class),
    "kerjasama" => \DI\create(Kerjasama::class),
    "halaman" => \DI\create(Halaman::class),
    "kudagang" => \DI\create(Kudagang::class),
    "akun" => \DI\create(Akun::class),
    "w_pelatihan" => \DI\create(WPelatihan::class),
    "w_orders" => \DI\create(WOrders::class),
    "konfimasi_pembayaran" => \DI\create(KonfimasiPembayaran::class),
    "akunku" => \DI\create(Akunku::class),
    "t_kota" => \DI\create(TKota::class),
    "t_prop" => \DI\create(TProp::class),
    "pelatihanekspor" => \DI\create(Pelatihanekspor::class),
    "pelatihanmetrologi" => \DI\create(Pelatihanmetrologi::class),
    "pelatihanmutu" => \DI\create(Pelatihanmutu::class),
    "w_berita" => \DI\create(WBerita::class),
    "w_kat_berita" => \DI\create(WKatBerita::class),
    "pelatihanjasaperdagangan" => \DI\create(Pelatihanjasaperdagangan::class),
    "lspppejp" => \DI\create(Lspppejp::class),
    "lspbpmjp" => \DI\create(Lspbpmjp::class),
    "artikel" => \DI\create(Artikel::class),
    "w_settings" => \DI\create(WSettings::class),
    "w_userlevelpermissions" => \DI\create(WUserlevelpermissions::class),
    "w_userlevels" => \DI\create(WUserlevels::class),
    "formpendaftaran" => \DI\create(Formpendaftaran::class),
    "sertifikasikompetensi" => \DI\create(Sertifikasikompetensi::class),
    "w_testimoni" => \DI\create(WTestimoni::class),
    "faq" => \DI\create(Faq::class),
    "caridata" => \DI\create(Caridata::class),

    // User table
    "usertable" => \DI\get("w_users"),
];
