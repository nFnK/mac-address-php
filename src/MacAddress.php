<?php
namespace nbczw8750\mac;
/**
 +------------------------------------------------------------------------------
 * MacAddress 获取服务器的网卡物理地址
 +------------------------------------------------------------------------------
 * @author    nbczw8750@qq.com
 * @version   v1.0
 +------------------------------------------------------------------------------
 */
class MacAddress
{
    var $returnArray = array(); // 返回带有MAC地址的字串数组
    var $macAddress=array();

    public function getMacAddress(){
        switch (strtolower(PHP_OS) )
        {
            case "linux":$this->forLinux();break;
            case "solaris":break;
            case "unix":break;
            case "aix":break;
            default:$this->forWindows();break;
        }


        $tempArray = array();
        foreach ( $this->returnArray as $value ){
            if ( preg_match( "/[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f]/i", $value, $tempArray ) ) {
                $this->macAddress[] = $tempArray[0];
            }
        }
        unset($tempArray);
        return $this->macAddress;
    }

    private function forWindows(){
        @exec("ipconfig /all", $this->returnArray);
        if ( $this->returnArray )
            return $this->returnArray;
        else{
            $ipconfig = $_SERVER["WINDIR"]."\system32\ipconfig.exe";
            if ( is_file($ipconfig) )
                @exec($ipconfig." /all", $this->returnArray);
            else
                @exec($_SERVER["WINDIR"]."\system\ipconfig.exe /all", $this->returnArray);
            return $this->returnArray;
        }
    }

    private function forLinux(){
        @exec("ifconfig -a", $this->returnArray);
        return $this->returnArray;
    }
}
