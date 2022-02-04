<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>JSP Functions</title>
<style type="text/css">
body {
	padding:0;
	margin:40px 20px;
	color:#333;	
	font:100%/1.4 "Segoe UI", "Segoe UI Light", "Segoe Script";
	font-size:14px;}
a {	
	color:inherit;}	
a:hover {
	text-decoration:none;}
tr {
	vertical-align:top;}	
ul, dl {
	padding:0;
	margin:0;
	list-style-type:none;}
h1, h2 {
	text-transform:capitalize;
	font-weight:normal;
	line-height:0.8;}
.hr {
	border-bottom:solid 1px #ccc;
	line-height:1;}
.tableWrap {
	overflow:auto;}
table {
	padding:0;
	margin:20px 0;
	width:100%;
	border-collapse:collapse;
	border-spacing:none;}
tr:hover td {
	background-color:#0093dd;
	color:white;}
th {
	padding:8px 15px;
	background-color:#ededed;
	text-align:left;
	border-bottom:solid 2px #ccc;}
td {
	padding:5px 10px;
	border-bottom:solid thin #ccc;}
.footer {
	padding:20px 0 0 0;
	text-align:center;}
</style>
</head>
<body id="top">
		<h1>jasper, <span style="color:#0093dd;">JSP</span> functions</h1>
    <div class="hr">&nbsp;</div>    
    	<h2>JSP introduction</h2>
        JSP functions are purpose-built programming methods assembled in <abbr title="Javelin Jasper Librabry">JJL</abbr> files which enables developers efficiently utilize PHP scripts in small and large scale web applications with the design principles of speed and accuracy.
    <p></p>
        JSP supports both required and non-required function parameters. JSP modules range from basic PHP fucntions to comprehensive sorting techniques, superior file management systems and database communications via MySQL.
    <div class="hr">&nbsp;</div>    
    	<h2>Installation</h2>
        JSP functions are part of the Javelin&trade; RAD Framework developed by HWP Labs. To access JSP functions, simply;
        <ol>
			<li>Download and extract <a href="#">Javelin</a> from the official HWP Labs website resource page.</li>        	
        	<li>Create a folder called <code>Bin</code> in your application site or project folder.</li>
            <li>Place the Javelin folder inside the Bin folder.</li>
            <li>Open (with browser) the Jasper-Reference.xml file located in <code>Project/Bin/Javelin/Documentation/</code> to view the JSP Functions documentation.</li>            
       </ol>
    <div class="hr">&nbsp;</div>    
    	<h2>JSP functions</h2>        
	<strong>RID </strong>: Reference ID of the specified function. <br/>        
	<strong>Param </strong>: Required function parameters where applicable. <br/>
    <strong>DPN </strong>: The total number of function dependencies. <br/> 
    <strong>CTO </strong>: Reference IDs of the functions used in the method design. <br/>                 
    <strong>CBY </strong>: Reference IDs of the functions that use the method design. <br/>                     
    <strong>Dir </strong>: The file directory of the specified function.
    <div class="tableWrap">
        <table>
            <tr>
                <th>S/N</th>  
                <th>RID</th>                        
                <th>Function</th>
                <th>Paramarater</th>            
                <th>Method</th>
                <th>Exception</th>
                <th>DPN</th>                                
                <th>CTO</th>                                
                <th>CBY</th>                                                                                                              
                <th>Directory</th>                        
            </tr>
            <tr>
                <td>1</td>  
                <td>JAS/DIC/001</td>                      
                <td>jspif</td>        
                <td>&nbsp;</td>              
                <td>One or more of a defined function parameters is not supported by the function specification</td>        
                <td>&nbsp;</td>               
                <td>2</td>                                  
                <td>JAS/DIC/001</td>                                  
                <td>JAS/DIC/001</td>                                                                  
                <td>../Jasper/Jasper-Dictionary</td>                        
            </tr> 
            <tr>
                <td>2</td>  
                <td>JAS/DIC/001</td>                      
                <td>jsp_ip()</td>        
                <td>&nbsp;</td>              
                <td>One or more of a defined function parameters is not supported by the function specification</td>        
                <td>&nbsp;</td>               
                <td>2</td>                                  
                <td>JAS/DIC/001</td>                                  
                <td>JAS/DIC/001</td>                                                                  
                <td>../Jasper/Jasper-Dictionary</td>                        
            </tr> 
            <tr>
                <td>3</td>  
                <td>JAS/DIC/001</td>                      
                <td>jsp_device</td>        
                <td>&nbsp;</td>              
                <td>One or more of a defined function parameters is not supported by the function specification</td>        
                <td>&nbsp;</td>               
                <td>2</td>                                  
                <td>JAS/DIC/001</td>                                  
                <td>JAS/DIC/001</td>                                                                  
                <td>../Jasper/Jasper-Dictionary</td>                        
            </tr> 
            <tr>
                <td>4</td>  
                <td>JAS/DIC/001</td>                      
                <td>jsp_date_long</td>        
                <td>&nbsp;</td>              
                <td>One or more of a defined function parameters is not supported by the function specification</td>        
                <td>&nbsp;</td>               
                <td>2</td>                                  
                <td>JAS/DIC/001</td>                                  
                <td>JAS/DIC/001</td>                                                                  
                <td>../Jasper/Jasper-Dictionary</td>                        
            </tr>                             
            <tr>
                <td>5</td>  
                <td>JAS/DIC/001</td>                      
                <td>jsp_global_fields()</td>  
                <td>&nbsp;</td>              
                <td>One or more of a defined function parameters is not supported by the function specification</td>        
                <td>&nbsp;</td>               
                <td>2</td>                                  
                <td>JAS/DIC/001</td>                                  
                <td>JAS/DIC/001</td>                                                                  
                <td>../Jasper/Jasper-Dictionary</td>                        
            </tr>                                        
        </table>
    </div>
    <div class="footer">
        Javelin Jasper Library (JJL) is authored, reviewed and updated by HWP Labs framework engineering team.
        <p></p>
        Copyright &copy; 2011-2016 HWP Labs. All Rights Reserved.
    </div>
</body>
</html>
