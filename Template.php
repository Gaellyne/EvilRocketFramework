<?php

    /**
     * @author BreathLess
     * @type Library
     * @description: Template Engine ported from Codeine
     * @package Evil
     * @subpackage Rendering
     * @version 0.1
     * @date 29.10.10
     * @time 14:29
     */

    class Evil_Template
    {
        private $_template = '';
        private $_data = array();
        private $_fusers = array('key');

        public function __construct ($fusers = null)
        {
            if (null !== $fusers)
                $this->_fusers = $fusers;

        }

        private function _load ($template)
        {
            $this->_template = file_get_contents(APPLICATION_PATH.'/views/templates/'.$template.'.phtml');
        }

        public function mix ($data, $template = null)
        {
            $this->_data = $data;
            $this->_load($template);

            $body = $this->_template;

            foreach ($this->_fusers as $fuser)
            {
                $fn = '_'.$fuser.'Tag';
                $body = $this->$fn($body);
            }

            return $body;
        }

        private function _keyTag ($body)
        {            
            if (preg_match_all('@<k>(.*)</k>@SsUu', $body, $pockets))
                foreach ($pockets[1] as $ix => $match)
                {
                    if (isset($this->_data[$match]))
                        $replace = $this->_data[$match];
                    else
                        $replace = '';

                    $body = str_replace($pockets[0][$ix], $replace, $body);
                }
            
            return $body;
        }
    }