<?php
    include_once("controller/PartidaController.php");
    include_once("model/PartidaModel.php");
    include_once("controller/EditorController.php");
    include_once("model/EditorModel.php");
    include_once ("controller/UsuarioController.php");
    include_once ("model/UsuarioModel.php");
    include_once ("controller/AdminController.php");
    include_once ("model/AdminModel.php");
    include_once("helper/Conexion_db.php");
    include_once ("helper/Presenter.php");
    include_once ("helper/MustachePresenter.php");
    include_once ("helper/Router.php");
    include_once ("helper/SenderEmailPHPMailer.php");
    include_once ("helper/descargar_pdf.php");
    include_once ("helper/GeneradorQR.php");
    include_once("controller/AdminController.php");
    include_once("model/AdminModel.php");

    include_once('vendor/mustache/src/Mustache/Autoloader.php');
    class Configuration
    {
        public static function getAdminController()
        {
            return new AdminController(self::getAdminModel(), self::getPresenter(),self::getDescargar_pdf());

        }

        private static function getDescargar_pdf()
        {
            return new descargar_pdf();
        }

        private static function getAdminModel()
        {
            return new AdminModel(self::getDatabase());
        }
        public static function getUsuarioController()
        {
            return new UsuarioController(self::getUsuarioModel(), self::getPresenter(), self::getPartidaModel(), self::getSenderEmailPHPMailer(),self::getGeneradorQR());

        }
        private static function getUsuarioModel()
        {
            return new UsuarioModel(self::getDatabase());
        }

        private static function getSenderEmailPHPMailer()
        {
            return new SenderEmailPHPMailer();
        }

        private static function getGeneradorQR()
        {
            return new GeneradorQR();
        }
        public static function getEditorController()
        {
            return new EditorController(self::getEditorModel(), self::getPresenter(),self::getUsuarioModel());

        }
        private static function getEditorModel()
        {
            return new EditorModel(self::getDatabase());
        }
        public static function getPartidaController()
        {
            return new PartidaController(self::getPartidaModel(), self::getPresenter());

        }
        private static function getPartidaModel()
        {
            return new PartidaModel(self::getDatabase());
        }
        public static function getDatabase()
        {
            $config = self::getConfig();
            return new Database($config["servername"], $config["username"], $config["password"], $config["database"]);
        }
        private static function getConfig()
        {
            return parse_ini_file("config/db.ini");
        }
        public static function getRouter()
        {
            return new Router("getUsuarioController", "vistaLogin");

        }
        private static function getPresenter()
        {
            return new MustachePresenter("view/template");
        }
    }
?>
