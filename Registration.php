<?php
/**
 * @description Simplify for a registration action
 * @author Se#
 * @version 0.0.1
 */
class Evil_Registration
{
    /**
     * @description config extension
     * @var string
     * @author Se#
     * @version 0.0.1
     */
    public static $cfgExtension = 'json';

    /**
     * @description registration configuration
     * @var array|mixed
     * @author Se#
     * @version 0.0.1
     */
    protected $_cfg = array();

    /**
     * @description registration form
     * @var null
     * @author Se#
     * @version 0.0.1
     */
    protected $_form = null;

    /**
     * @throws Exception
     * @param string $path
     * @author Se#
     * @version 0.0.1
     */
    public function __construct($path = '')
    {
        $path = $path ? $path : APPLICATION_PATH . '/configs/forms/registration.' . self::$cfgExtension;
        if(!is_file($path))
            throw new Exception('Missed configuration for a registration');
        // todo fix by extension
        $this->_cfg = json_decode(file_get_contents($path), true);
    }

    /**
     * @description make registration form
     * @throws Exception
     * @return void
     * @author Se#
     * @version 0.0.1
     */
    public function makeForm()
    {
        if(isset($this->_cfg['form']))
            $this->_form = new Zend_Form($this->_cfg['form']);
        else
            throw new Exception('Missed registration form configuration');
    }

    /**
     * @description echo or return form
     * @param bool $return
     * @return bool|object
     * @author Se#
     * @version 0.0.1
     */
    public function form($return = false)
    {
        if($return)
            return $this->_form;
        else
            echo $this->_form;

        return true;
    }

    public function useCaptcha($captchaName, $args)
    {
        if(method_exists('Evil_Captcha_' . ucfirst($captchaName), 'challenge'))
        {
            // todo 
        }
    }
}