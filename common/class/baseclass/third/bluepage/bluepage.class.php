<?php
/**
 * @desc bluepage.class.php 
 * 功能: 用于分页!
 *  从之前的项目中 include/bluepage/里面拷贝过来，没做改
 *  源代码为：http://www.bluessoft.com/project/bluepage
 *  目前此域名已经被墙，此项目已经不能访问
 * @author alfa@condenast
 * @date 20110708
 */

/*
* ----------------------------------------------------
* ID     : BluePage.class
* Author : DJ <DJ@Bluessoft.com>
* ----------------------------------------------------
* Homepage: http://www.bluessoft.com/project/bluepage
* ----------------------------------------------------
*/

if ( ! class_exists ( "BluePage" ) )
{
    class BluePage
    {
    	var $_total ;               // 记录总数
    	var $_col ;                 // 每页显示数
    	var $_var     = 'page' ;    // 分页变量名，默认是page，请修改为您常用的变量名 	
    	var $_tvar    = 'total' ;   // 记录总数变量名
    	var $_setotal = true ;      // 是否自动将记录总数赋值到GET当中
    	var $_pos     = 3 ;         // 当前页在分页条中的位置
    	var $_hide    = true ;      // 是否隐藏重复分页
    	var $_prefix  = '' ;        // 分页值的前填,比如 p123中的p
    	var $_postfix = '' ;        // 分页值的后填,比如 123p中的p
    	var $_symbol  = '&' ;       // &或&amp;
    	var $_encode  = true ;      // 是否对query string过滤
  	    
  	    var $_getlink = true ;      // 是否建造链接
  	    var $_getqs   = true ;      // 是否取Query String
  	    var $_qs      = '' ;        // Query String
  	    
  	    var $_order = 't|f|pg|p|bar|n|ng|m|i' ;       // html的组合方式，参见配置文件
  	    var $_full  = 't|f|pg|p|bar|n|ng|m|sl|i' ;    // Full
  	    var $_file  = 'BluePage.default.inc.php' ;    // 默认分页html配置文件，需要与Pager.class.php同路径
    	
		/*
		参数说明:
		$nNum     显示多少个页码
		
		返回:
		$aPDatas['offset']   offset
		$aPDatas['m']        总页(最大页)数
		$aPDatas['m_ln']     总页(最大页)数 链接  需要$this->_getlink = true  以下相同
		$aPDatas['f_ln']     首页链接
		$aPDatas['t']        当前页码
		$aPDatas['p']        上一页页码
		$aPDatas['p_ln']     上一页 链接
		$aPDatas['n']        下一页
		$aPDatas['n_ln']     下一页 链接
		$aPDatas['ng']       下一组页码
		$aPDatas['ng_ln']    下一组链接
		$aPDatas['qs']       Query String ?号后面部份，需要$this->_getqs = true ;
		
		当$this->_getlink = false 时:
		$aPDatas['bar']      分页条，一维数组
		当$this->_getlink = true 时:
		$aPDatas['bar']      多维数组，$aPDatas['bar'][num'] 分页数字   $aPDatas['bar'][ln'] 分页链接
		*/
    	function get( $nTotal , $nCol , $nNum = 10 )
    	{
    		$this->_total = intval ( $nTotal ) ;
    		$this->_col   = intval ( $nCol ) ;
			$aPDatas = array( ) ;
   			if ( isset( $_REQUEST[$this->_var] ) )
   			{
   				( $nThisPage = $this->getPage( $_REQUEST[$this->_var] ) ) > 1  
				? $aPDatas['t'] = $nThisPage 
				: $aPDatas['t'] = $nThisPage = 1 ;
   			}
			else
			{
				$aPDatas['t'] = $nThisPage = 1 ;
			}

		    if ( $this->_total < 1 || $this->_col < 1 )
		    {
		        $aPDatas['offset'] = 0 ;
		        $aPDatas['t'] = $aPDatas['m'] = $aPDatas['p'] = $aPDatas['n'] = 1 ;
		    }
		    else
		    {
			    $aPDatas['offset']   = $this->_col * ( $nThisPage - 1 ) ; 
			    $aPDatas['m']  = ceil ( $this->_total / $this->_col ) ;
			    $aPDatas['p']  = $nThisPage < 2 ? 1 : $nThisPage - 1 ;
			    $aPDatas['n'] = $nThisPage == $aPDatas['m'] ? $aPDatas['m']  : $nThisPage + 1 ;
		    }
		    
		    if ( $this->_getlink )
		    {
		    	$this->getQueryString () ;
		    	$aPDatas['m_ln']  = $this->setLink( $aPDatas['m'] ) ;
		        $aPDatas['p_ln']  = $this->setLink( $aPDatas['p'] ) ;
		        $aPDatas['n_ln']  = $this->setLink( $aPDatas['n'] ) ;
		        $aPDatas['f_ln']  = $this->setLink( 1 ) ;
		    }
		    $nNum = $nNum == 'all' ? $aPDatas['m'] :  intval ( $nNum ) ;

		    if ( $nNum ) 
		    {
			    $nSPage = ( $nSsPage = $nThisPage + 1 - $this->_pos ) < 1 ? 1 : $nSsPage ;
			    if ( $nSPage + $nNum > $aPDatas['m'] ) 
			    { 
			    	$nSPage = ( $nSsPage = $aPDatas['m'] - $nNum + 1 ) < 1 ? 1 : $nSsPage ;
			    }
			    $nEPage = ( $nEsPage = $nSPage + $nNum - 1 ) > $aPDatas['m'] 
			              ? $aPDatas['m'] : $nEsPage ; 
			    $aPDatas['pg']  = ( $nPGroup = $nThisPage - $nNum ) > 1 ?  $nPGroup  : 1 ;
			    $aPDatas['ng']  = ( $nNGroup = $nThisPage + $nNum ) < $aPDatas['m'] ? $nNGroup : $aPDatas['m'] ;
			    
			    $arrPageBar = array ( ) ; 
			    if ( $this->_getlink ) 
			    {
			    	$aPDatas['pg_ln'] = $this->setLink( $aPDatas['pg'] ) ; 
			    	$aPDatas['ng_ln'] = $this->setLink( $aPDatas['ng'] ) ;
			    	$k = 0 ;
			    	for ( $i = $nSPage ; $i <= $nEPage ; $i++ ) 
				    {
				        $arrPageBar[$k]['num']  = $i ;
				        $arrPageBar[$k]['ln'] = $this->setLink( $i ) ;
				        $k++ ;
				    }
			    }
			    else
			    {
				    for ( $i = $nSPage ; $i <= $nEPage ; $i++ ) 
				    {
				        $arrPageBar[] = $i ;
				    }
				}
			    $aPDatas['bar']  = $arrPageBar ;
			}
			if ( $this->_getqs )
			{
				if ( !$this->_qs )
				{
		    	    $this->getQueryString() ;
		    	    $aPDatas['qs'] = $this->_qs ;
		    	}
		    	else
		    	{
		    		$aPDatas['qs'] = $this->_qs ;
		    	}
			}
		    return $aPDatas ;
    	}
    	
    	function getFull( $aPDatas , $strHtmlFile = '' )
    	{
    		$this->_order = $this->_full ;
    		return $this->getHTML( $aPDatas , $strHtmlFile ) ;
    	}
    	
    	function getHTML_old( $aPDatas , $strHtmlFile = '' )
    	{
    	    if ( $strHtmlFile == '' )
    	    {
    	    	$strHtmlFile = strtolower(str_replace("\\" , "/", dirname( __FILE__ ) ) . '/'. $this->_file)  ;
    	    };
			//return $strHtmlFile;
    		if ( file_exists ( $strHtmlFile ) )
    		{
    			include ( $strHtmlFile ) ; 
    			$aPA = explode( "|" , $this->_order ) ; 
    			if ( is_array( $aPA )  ) 
    			{
    				$strHtmlBody = '' ;
    				foreach ( $aPA as $nPAkey )
    				{
    					switch ( $nPAkey )
    					{
    						case 't' : 
    							$strHtmlBody .= sprintf( $PA['t'] , $this->_total ) ;
    						    break ;
    						case 'm' :
    							if ( $aPDatas['t'] != $aPDatas['m'] or !$this->_hide )   				
    						    	$strHtmlBody .= sprintf( $PA['m'] , $aPDatas['m_ln'] , $aPDatas['m'] ) ;

    							break ;
    						case 'f' :
    							if ( $aPDatas['t'] != 1  or !$this->_hide )
    						    $strHtmlBody .= sprintf( $PA['f'] , $this->setLink(1) ) ;
    							break ;
    						case 'pg' :
    						    if ( $aPDatas['t'] > $this->_pos  or !$this->_hide ) 
    						    $strHtmlBody .= sprintf( $PA['pg'] , $aPDatas['pg_ln'] ) ;
    							break ;
    						case 'p' :
    						    if ( $aPDatas['t'] > 1 or !$this->_hide ) $strHtmlBody .= sprintf( $PA['p'] , $aPDatas['p_ln'] ) ;
    							break ;
    						case 'bar' :
    						    $strBar = '' ;
    						    foreach ( $aPDatas['bar'] AS $aPBar ) 
    						    {
    						    	if ( $aPBar['num'] == $aPDatas['t'] )
    						    	{
    						    		$strBar .=  sprintf( $PA['bar_cur'] , $aPBar['num'] ) ;
    						    	}
    						    	else
    						    	{
    						    		$strBar .= sprintf( $PA['bar'] , $aPBar['ln'] , $aPBar['num'] ) ;
    						    	}
    						    }
    						    $strHtmlBody .= $strBar ;
    							break ;
    						case 'ng' :
    							if ( ( $aPDatas['t'] < $aPDatas['m'] + $this->_pos  - sizeof( $aPDatas['bar']) ) or !$this->_hide )
    						    	$strHtmlBody .= sprintf( $PA['ng'] , $aPDatas['ng_ln'] ) ;
    							break ;
    						case 'n' :
    							if ( $aPDatas['t'] < $aPDatas['m'] or !$this->_hide )
    						    $strHtmlBody .= sprintf( $PA['n'] , $aPDatas['n_ln'] ) ;
    							break ;
    						case 'sl':
    						    $strHtmlBody .= $this->getSlection ( $aPDatas['m'] , $PA['sl_head'] , $PA['sl'] , $PA['sl_end'] ) ;
    						    break ;
    						case 'i':
    						    $strHtmlBody .= sprintf( $PA['i'] , $aPDatas['qs'] , $this->_var, $this->_prefix , $this->_postfix ) ;
    						    break ;
    					}
    				}
    				return $PA['head'].$strHtmlBody.$PA['end'] ;
    			}
    		}
    		
            return '' ;
    	}
    	
    	function getHTML( $aPDatas , $strHtmlFile = '' )
    	{
    	    if ( $strHtmlFile == '' )
    	    {
    	    	$strHtmlFile = str_replace("\\" , "/", dirname( __FILE__ ) ) . '/'.strtolower( $this->_file)  ;
    	    };
			//return $strHtmlFile;
    		if ( file_exists ( $strHtmlFile ) )
    		{
    			include ( $strHtmlFile ) ; 
    			$aPA = explode( "|" , $this->_order ) ; 
    			if ( is_array( $aPA )  ) 
    			{
					if ($aPDatas['qs'] )
					{
						//$tmpstr=explode($aPDatas['qs'],'&');
						//$url_pg=str_replace($aPDatas['qs'],'pg='.$this->_col,'pg=+this.value');
						$urlpg=$_SERVER['SCRIPT_NAME']."?".$aPDatas['qs'];
						$urlpage=$_SERVER['SCRIPT_NAME']."?".$aPDatas['qs'];
						/*
						foreach ($tmpstr as $key=>$value)
						{
							echo $aPDatas['qs'];
						}*/
					}
					else
					{
						$urlpg=$_SERVER['SCRIPT_NAME']."?";	
						$urlpage=$_SERVER['SCRIPT_NAME']."?";					
					}
					
					$strHtmlhead="<div class='page_box gray'>				<div class='page_right'>					共".$this->_total."条记录　共".$aPDatas['m']."页　第					<select name='select' class='select'   onchange=\"javascript:location.href='".$urlpage."page='+this.value\">";
					$strHtmlBody="";
					for($i=1;$i<=$aPDatas['m'];$i++)
					{
						if ($_GET['page']==$i)
						{
							$t="  selected='selected'";
						}
						else
						{
							$t='';
						}
						$strHtmlBody.="<option value='$i' $t>$i</option>";
					}
					$strHtmlend1="</select>					页				</div>				<div class='page_left'>					每页显示					<select name='select' class='select' onchange=\"javascript:location.href='".$urlpg."pg='+this.value\">	";		
					$strHtmlend='';
					$tp='';
					for($j=1;$j<=5;$j++)
					{
						$tmpj=$j*10;
						if ($_GET['pg']==$tmpj)
						{
							$tp="  selected='selected'";
						}
						else
						{
							$tp='';
						}
						$strHtmlend.=" <option value='$tmpj' $tp>$tmpj</option>					  ";
					}
					$strHtmlend2="</select>					条记录				</div>			</div><p class='clear'></p>" ;
    				return $strHtmlhead.$strHtmlBody.$strHtmlend1.$strHtmlend.$strHtmlend2;
    			}
    		}
    		
            return '' ;
    	}
    	
    	function getPage( $mxPage ) 
    	{
    		if ( $this->_prefix )  $mxPage = str_replace( $this->_prefix  , '' , $mxPage ) ;
    		if ( $this->_postfix ) $mxPage = str_replace( $this->_postfix , '' , $mxPage ) ;
    		return intval( $mxPage ) ;
    	}
    	
    	function setLink( $nPage )
    	{
    		if ( $this->_setotal && !isset( $_REQUEST[$this->_tvar] ) )
    		{
    			$strLink = $this->_qs ? '?' . $this->_tvar . '=' . $this->_total . $this->_symbol . $this->_qs . $this->_var . '=' . $this->_prefix . $nPage . $this->_postfix 
    		                          : '?' . $this->_tvar . '=' . $this->_total . $this->_symbol . $this->_var . '=' . $this->_prefix . $nPage . $this->_postfix  ; 
    		}
    		else
    		{
    			$strLink = $this->_qs ? '?' . $this->_qs . $this->_var . '=' . $this->_prefix . $nPage . $this->_postfix 
    		                           : '?' . $this->_var . '=' . $this->_prefix . $nPage . $this->_postfix ; 
    		}

    		return $strLink ;
    	}
    	
    	function getSlection ( $nMaxPage , $strSLHead , $strSL , $strSLEnd )
    	{
    		$nMax = intval ( $nMaxPage ) ; 
    		if ($nMax < 1 ) return;
    		if ( isset($_REQUEST[$this->_var]))
    		{
    			$nThisPage = $this->getPage( $_REQUEST[$this->_var] ) ;
    			if ( $nThisPage < 1 ) $nThisPage = 1 ; 
    			if ( $nThisPage > $nMax ) $nThisPage = $nMax ;
    		}
    		else
    		{
    			$nThisPage = 1 ;
    		}
						
			$strSLBODY = '' ;
			for ( $i = 1 ; $i<= $nMax ; $i++ )
			{
		        $strSLBODY .= sprintf( $strSL , $this->_qs , $this->_var , $this->_prefix ,  $this->_postfix , $i  ) ;
			}
			$strPattern = '/(\>' . $nThisPage . '<\/option>)/i' ;
			preg_match_all( $strPattern, $strSLBODY , $arrResult );
			$strSLBODY = str_replace( $arrResult[1][0], " selected " . $arrResult[1][0],$strSLBODY ) ;
			return $strSLHead . $strSLBODY . $strSLEnd  ;

    	}
    	
    	function getQueryString( )
    	{
    		$strPagepattern = '/('.$this->_var.'=('.$this->_prefix.')\d{0,}('.$this->_postfix.'))/' ;
 
		    preg_match_all( $strPagepattern, $_SERVER["QUERY_STRING"] , $arrResult );
		    if ( $arrResult[1] )
		    {
		    	$strQueryString = $arrResult[1][0] ? str_replace( "&".$arrResult[1][0] , "" , $_SERVER["QUERY_STRING"] ) : $_SERVER["QUERY_STRING"];
		    	$strQueryString = str_replace( $arrResult[1][0] , "" , $strQueryString ) ; 
		    }
		    else
		    {
		    	$strQueryString = $_SERVER["QUERY_STRING"] ;
		    }
		    
		    if ( $strQueryString ) 
		    {
		    	$strQueryString = $this->_encode ? htmlspecialchars($strQueryString).$this->_symbol : $strQueryString.$this->_symbol ;
		    } 
		    $this->_qs =  $strQueryString  ;
		    return true ;
    	}
    	
    	/*
    	//这是mysql取记录数的函数
		function myGetCount( $strQuery , $rsConn )
		{
		    $resResult = @mysql_query ( $strQuery , $rsConn ) ;
		    while ( $arrRow = @mysql_fetch_row ( $resResult ) ) 
		    {
		        $nCount = $arrRow[0] ; 
		    }
		    @mysql_free_result( $resResult ) ;
		    return intval( $nCount ) ;
		}
		
		//这是SQLserver取记录数的函数
		function msGetCount( $strQuery , $rsConn )
		{
		    $resResult = @mssql_query ( $strQuery , $rsConn ) ;
		    while ( $arrRow = @mssql_fetch_row ( $resResult ) ) 
		    {
		        $nCount = $arrRow[0] ; 
		    }
		    @mssql_free_result( $resResult ) ;
		    return intval( $nCount ) ;
		}
    	*/
    }
}
?>