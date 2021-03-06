<?php

    /**
     * @author BreathLess
     * @type Driver
     * @description: System Real Account
     * @package Evil
     * @subpackage Sensor
     * @version 0.1
     * @date 29.11.10
     * @time 13:04
     */

    class Evil_Sensor_SRA implements Evil_Sensor_Interface
    {
        public function track ($source, $args = null)
        {
            $sva = Score_Money_Account::load(Score_Money_Core::config('accounts', 'system', 'real'));
		    return (round($sva->sum(),2));
        }
    }