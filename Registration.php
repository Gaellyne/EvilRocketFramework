<?php
/**
 * @description Simplify for a registration action
 * @author Se#
 * @version 0.0.3
 * @changeLog
 * 0.0.3 see dispatch() v.0.0.2
 * 0.0.2 dispatch()
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

    /**
     * @description add CAPTCHA to a form
     * @param string $captchaName
     * @param array $args
     * @return void
     * @author Se#
     * @version 0.0.1
     */
    public function useCaptcha($captchaName, $args)
    {
        if(method_exists('Evil_Captcha_' . ucfirst($captchaName), 'challenge'))
        {
            // todo 
        }
    }

    /**
     * @description dispatch the request for a registration
     * @param array $params
     * @param Zend_Controller_Request_Abstract $request
     * @return bool
     * @author Se#
     * @version 0.0.2
     * @changeLog
     * 0.0.2 return bool
     */
    public function dispatch(array $params, $request)
    {
        if ($request->isPost())
        {
            $this->makeForm();
            if($this->_form->isValid($params))
            {
                if(isset($this->_cfg['dispatch']['filters']) && is_array($this->_cfg['dispatch']['filters']))
                {
                    $count  = count($this->_cfg['dispatch']['filters']);
                    $result = $params;

                    for($i = 0; $i < $count; $i++)
                    {
                        $result = call_user_func_array($this->_cfg['dispatch']['filters'][$i], array($result));
                        if(!$result)
                            throw new Exception('Filtering failed');
                    }
                }

                if(isset($this->_cfg['dispatch']['db']) && is_array($this->_cfg['dispatch']['db']))
                {
                    $result = $this->_clear($result);
                    if(isset($this->_cfg['dispatch']['db']['tableName']))
                    {
                        $table = new Zend_Db_Table(Evil_DB::scope2table($this->_cfg['dispatch']['db']['tableName']));
                        $table->insert($result);
                    }
                    else
                        return false;
                }
            }
            else
                return false;
        }
        else
            return false;

        return true;
    }

    /**
     * @description clear params from sys-info
     * @param array $params
     * @return array
     * @author Se#
     * @version 0.0.1
     */
    protected function _clear(array $params)
    {
        if(isset($params['action']))
            unset($params['action']);

        if(isset($params['controller']))
            unset($params['controller']);

        if(isset($params['module']))
            unset($params['module']);

        if(isset($params['submit']))
            unset($params['submit']);

        return $params;
    }
}