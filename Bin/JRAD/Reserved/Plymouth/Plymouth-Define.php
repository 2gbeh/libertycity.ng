<?php
//PLY_GLOBAL_TABLE
define('PLY_TABLE_BACKDOOR','Backdoor_tb');
define('PLY_TABLE_CRON','Cron_tb');
define('PLY_TABLE_MATCH','Match_tb');
define('PLY_TABLE_PLAN','Plan_tb');
define('PLY_TABLE_REF','Ref_tb');
define('PLY_TABLE_SLIDE','Slide_tb');
define('PLY_TABLE_SUSPEND','Suspend_tb');

//PLY_GLOBAL_page
define('PLY_PAGE_LANDING','Home.php');
define('PLY_PAGE_LOGIN','Login.php');
define('PLY_PAGE_DASHBOARD','Dashboard-Home.php');

//PLY_GLOBAL_BASE
define('PLY_BASE_SLIDE',JSP_PAGE_ROOT.'Media/Image/Slide/');
define('PLY_BASE_TELLER',JSP_PAGE_ROOT.'Media/Image/Teller/');

//PLY_GLOBAL_USER
define('PLY_USER_EMAIL',$_USER['email']);
define('PLY_USER_USERNAME',$_USER['username']);
define('PLY_USER_PASSWORD',$_USER['password']);
define('PLY_USER_NUMBER',$_USER['number']);
define('PLY_USER_STATE',_ENUMS('STATE',$_USER['state']));
define('PLY_USER_BANK',_ENUMS('BANK',$_USER['bank']));
define('PLY_USER_ACCNAME',JSP_TITLE_CASE($_USER['acc_name']));
define('PLY_USER_ACCNUMBER',$_USER['acc_number']);
define('PLY_USER_ACCTYPE',_ENUMS('ACC_TYPE',$_USER['acc_type']));
define('PLY_USER_STATUS',$_USER['status']);
define('PLY_USER_DATE',JSP_CAL_MKFORMAT($_USER['date'],'DATE','METRO'));
define('PLY_USER_TIME',JSP_CAL_MKFORMAT($_USER['time'],'TIME','PRESET'));
define('PLY_USER_ID',$_USER['id']);


//PLY_GLOBAL_REF
$_REF = _SWITCH(PLY_TABLE_REF,'user_rid',$_USER['id']);
$PLY_REF_BY = JSP_FETCH_CELLOF(JSP_TABLE_USER,'username',$_REF['ref_by']);
$PLY_REF_PLAN = _SWITCH(PLY_TABLE_PLAN,'PRIKEY',$_REF['plan_id']);
define('PLY_REF_ID',PLY_USER_USERNAME);
define('PLY_REF_BY',$PLY_REF_BY);
define('PLY_REF_PLAN',$PLY_REF_PLAN['name']);
define('PLY_REF_LINK',DOMAIN.'?ref='.PLY_USER_USERNAME);


//PLY_GLOBAL_MATCH
$_MATCH = _THROW(_SWITCH(PLY_TABLE_MATCH,'user_rid',$_USER['id']));
$_MATCHLAST = _THROW(JSP_SSQL_LAST(PLY_TABLE_MATCH,'user_rid',$_USER['id']));
$_MATCHLAST_PLAN = _SWITCH(PLY_TABLE_PLAN,'PRIKEY',$_MATCHLAST['plan_id']);
$_MATCHLAST_USER = _SWITCH(JSP_TABLE_USER,'PRIKEY',$_MATCHLAST['matched']);
define('PLY_MATCH_TYPE','200');
define('PLY_MATCH_TIME','24');
define('PLY_MATCH_TOTAL',count(_DIMARRAY($_MATCH)));
define('PLY_MATCH_PLAN',$_MATCHLAST_PLAN['name']);
define('PLY_MATCH_AMOUNT',_RICHDENOM($_MATCHLAST_PLAN['amount']));
define('PLY_MATCH_USERID',$_MATCHLAST['matched']);
define('PLY_MATCH_USERNAME',$_MATCHLAST_USER['username']);
define('PLY_MATCH_NUMBER',JSP_NUMBER_CASE($_MATCHLAST_USER['number'],'PRESET'));
define('PLY_MATCH_BANK',_ENUMS('BANK',$_MATCHLAST_USER['bank']));
define('PLY_MATCH_ACCNAME',JSP_TITLE_CASE($_MATCHLAST_USER['acc_name']));
define('PLY_MATCH_ACCNUMBER',$_MATCHLAST_USER['acc_number']);
define('PLY_MATCH_TELLER',$_MATCHLAST['teller']);
define('PLY_MATCH_STATUS',$_MATCHLAST['status']);
define('PLY_MATCH_DATE',JSP_CAL_MKFORMAT($_MATCHLAST['date'],'DATE','METRO'));
define('PLY_MATCH_TIME',JSP_CAL_MKFORMAT($_MATCHLAST['time'],'TIME','PRESET'));
define('PLY_MATCH_ID',$_MATCHLAST['id']);

?>