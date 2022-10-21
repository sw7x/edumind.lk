
<?php
date_default_timezone_set('Asia/Colombo');
$date= date("d-m-Y h:i:s A", time()) ;
?>



<table cellpadding="0" cellspacing="0" style="border:none;font-family:Arial,Helvetica,sans-serif;font-size:11px;color:#505050" width="100%">
    <tbody>
    <tr>
        <td align="center">
            <table cellpadding="0" cellspacing="0" style="border:none;font-family:Arial,Helvetica,sans-serif;font-size:11px;color:#505050" width="550">
                <tbody>
                <tr>
                    <td bgcolor="#FFFFFF">
                        <table cellpadding="0" cellspacing="0" style="background:#171616;border:none;font-family:Arial,Helvetica,sans-serif;font-size:11px;color:#505050;padding:8px 20px 10px 20px" width="100%">
                            <tbody>
                            <tr>
                                <td align="left">
                                    <a href="{{URL::to('/')}}" target="_blank" title="Edumind.lk website">
                                        <img style="width:150px;" src="{{asset('images/logo.png')}}" alt="Edumind.lk Logo" title="Edumind.lk Logo">
                                    </a>

                                </td>
                                <td align="right" style="font-size:12px;color:#fff" valign="bottom">{{$date}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <table cellpadding="0" cellspacing="0" style="border:none;font-family:Arial,Helvetica,sans-serif;font-size:11px;color:#505050" width="100%">
                            <tbody>
                            <tr>
                                <td align="right" bgcolor="#2D2D2D" height="2" style="width:100%;height:2px;float:left"></td>
                            </tr>
                            </tbody>
                        </table>
                        <table cellpadding="0" cellspacing="0" style="border:none" width="100%">
                            <tbody>
                            <tr>
                                <td align="left" style="padding:17px 20px" valign="top">
                                    <div style="font-family:Arial,Helvetica,sans-serif;font-size:20px;color:#404040">Edumind</div>
                                    <div style="font-family:Arial,Helvetica,sans-serif;font-size:16px;color:#7789a2">Account activation (Student)</div>

                                    
                                    <p style="font-size: 14px;margin:5px 0px 0px 0px;">Your Username - {{$username}}</p>
                                    

                                    <div style="font-size:11px;padding:18px 0 20px 0">
                                        <p style="font-size: 14px;margin: 0px;">Please click the following link to activate your account in Edumind.lk</p>
                                        <a href="{{$actionLink}}">{{$actionLink}}</a>
                                    </div>

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table cellpadding="0" cellspacing="0" style="border:none" width="100%">
                            <tbody>
                            <tr>
                                <td bgcolor="#2D2D2D" height="5" width="540"></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <table cellpadding="0" cellspacing="0" style="padding:8px 20px 10px 20px;font-family:Arial,Helvetica,sans-serif;font-size:11px;color:#505050" width="100%">
                                        <tbody>
                                        <tr>
                                            <td align="left"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
