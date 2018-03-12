<?php
namespace grenhaz\yii-userlog;

use Yii;
use yii\log\FileTarget;
use yii\helpers\FileHelper;

/**
 * Clase para el log de usuarios.
 * 
 * @author obarcia
 * @link http://www.yiiframework.com/doc-2.0/yii-log-filetarget.html
 */
class UserLogger extends FileTarget
{
    /**
     * Nombre del fichero.
     * @var string
     */
    public $name = "user";
    
    /**
     * Devuelve la ruta al fichero de log actual.
     * @return string Ruta al fichero de log actual.
     */
    public function getCurrentLogFile()
    {
        if ( Yii::$app->user != null && Yii::$app->user->identity != null && !Yii::$app->user->isGuest) {
            // Si está validado el usuario se guarda en su directorio
            return Yii::getAlias( '@app/runtime/logs/' . Yii::$app->user->identity->id . '/'.$this->name.'.log' );
        } else {
            // Si no está validado el usuario se guarda en uno general
            return Yii::getAlias( '@app/runtime/logs/'.$this->name.'.log' );
        }
    }
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
	
        // Obtener el fichero de log
        $this->logFile = $this->getCurrentLogFile();
		
        // Crear el directorio si no existiera
        $logPath = dirname( $this->logFile );
        if ( !is_dir( $logPath ) ) {
            FileHelper::createDirectory( $logPath, $this->dirMode, true );
        }
    }
}