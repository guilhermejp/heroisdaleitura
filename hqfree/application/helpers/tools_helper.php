<?php
/**
 * @author Devlink
 * Class Tools
 * Type: Helpers
 */
class Tools
{
	/**
	 * @static
	 * @method FormatDateTime
	 * @param timestamp
	 * @return string
	 * @desc Formata um timestamp para string
	 */
	public static function FormatDateTime($datetime)
	{
		$result = null;

		if(isset($datetime))
		{
			$date = substr($datetime, 0, 10);
			$time = substr($datetime, 11, 8);

			$dt = explode("-", $date);
			$result = $dt[2]."/".$dt[1]."/".$dt[0]." ".$time;
		}

		return $result;
	}
	
	/**
	 * @method FormatDateTime
	 * @param timestamp
	 * @return string
	 * @desc Formata um timestamp para string
	 */
	public static function FormatDateTimePar($datetime, $format)
	{
		$result = null;

		if (!empty($datetime) || self::IsValidDateTime($datetime))
		{
			return date($format, strtotime($datetime));
		}

		return $result;
	}
	
	/**
	 * @static
	 * @method FormatDateTime
	 * @param $datetime $format
	 * @return boolean
	 * @desc Check DateTime
	 */
	public static function IsValidDateTime($datetime, $format = 'YYYY-MM-DD')
	{
		if (strlen($datetime) >= 8 && strlen($datetime) <= 10)
		{
			$separator_only = str_replace(array('M', 'D', 'Y'), '', $format);
			$separator = $separator_only[0];
			if ($separator)
			{
				$regexp = str_replace($separator, "\\" . $separator, $format);
				$regexp = str_replace('MM', '(0[1-9]|1[0-2])', $regexp);
				$regexp = str_replace('M', '(0?[1-9]|1[0-2])', $regexp);
				$regexp = str_replace('DD', '(0[1-9]|[1-2][0-9]|3[0-1])', $regexp);
				$regexp = str_replace('D', '(0?[1-9]|[1-2][0-9]|3[0-1])', $regexp);
				$regexp = str_replace('YYYY', '\d{4}', $regexp);
				$regexp = str_replace('YY', '\d{2}', $regexp);
				if ($regexp != $datetime && preg_match('/' . $regexp . '$/', $datetime))
				{
					foreach (array_combine(explode($separator, $format), explode($separator, $datetime)) as $key => $value)
					{
						if ($key == 'YY')
							$year = '20' . $value;
						if ($key == 'YYYY')
							$year = $value;
						if ($key[0] == 'M')
							$month = $value;
						if ($key[0] == 'D')
							$day = $value;
					}
					if (checkdate($month, $day, $year))
						return true;
				}
			}
		}
		return false;
	}

	/**
	 * @static
	 * @method FormatCode
	 * @param int
	 * @return string
	 * @desc Formata um inteiro para string adicionando 0 (zero)
	 * para completar o tamanho do código na string
	 */
	public static function FormatCode($code,$size=6)
	{
		$Char = "0";
		$QtdChr = $size;

		$QtdComp = $QtdChr - strlen($code);
		$StrTmp = $code;

		for ( $x=0;$x<$QtdComp;$x++)
		{
			$StrTmp  = $Char . $StrTmp;
		}

		return $StrTmp;
	}

	public static function Count($array)
	{
		$count = 0;
		if(!is_null($array) && !empty($array) && count($array) > 0)
		{
			foreach($array->result() as $rows)
			{
				$count++;
			}
		}

		return $count;
	}

	public static function IsValidArray($array)
	{
		$count = 0;

		if(!is_null($array) && !empty($array) && count($array) > 0)
		{
			$count = count($array);
		}

		return $count;
	}

	public static function IsValidObject($array)
	{
		$count = 0;

		if(!is_null($array) && !empty($array) && count($array) > 0)
		{
			foreach($array->result() as $rows)
			{
				$count++;
			}
		}

		return $count;
	}

	public static function IsValid($obj)
	{
		$count = 0;

		if(!is_null($obj) && !empty($obj))
		{
			$count++;
		}

		return $count;
	}
	
	public static function IsValidNumber($num)
	{
		$count = 0;

		if(!empty($num) && is_numeric($num) && $num > 0)
		{
			$count++;
		}

		return $count;
	}

	public static function IsNullOrEmpty($obj)
	{
		$count = 0;

		if(is_null($obj) || empty($obj))
		{
			$count++;
		}

		return $count;
	}

	public static function RemoveSpecialCaracter($text, $notRemoveSpace=FALSE)
	{
		if(!$notRemoveSpace)
		{
			$text = str_replace(" ", "_", $text);
		}
		
		$text = str_replace("ç", "c", $text);
		$text = str_replace("Ç", "C", $text);

		$text = str_replace("â", "a", $text);
		$text = str_replace("ã", "a", $text);
		$text = str_replace("á", "a", $text);
		$text = str_replace("à", "a", $text);
		$text = str_replace("Â", "A", $text);
		$text = str_replace("Ã", "A", $text);
		$text = str_replace("Á", "A", $text);
		$text = str_replace("À", "A", $text);

		$text = str_replace("é", "e", $text);
		$text = str_replace("ê", "e", $text);
		$text = str_replace("É", "E", $text);
		$text = str_replace("Ê", "E", $text);

		$text = str_replace("í", "i", $text);
		$text = str_replace("î", "i", $text);
		$text = str_replace("Í", "I", $text);
		$text = str_replace("Î", "I", $text);

		$text = str_replace("ó", "o", $text);
		$text = str_replace("õ", "o", $text);
		$text = str_replace("ô", "o", $text);
		$text = str_replace("Ó", "O", $text);
		$text = str_replace("Õ", "O", $text);
		$text = str_replace("Ô", "O", $text);

		$text = str_replace("ú", "u", $text);
		$text = str_replace("Ú", "U", $text);

		//
		return $text;
	}
        
    public static function RemoveSpecialCaracterUpload($str)
    {			
			$str = preg_replace('/ /', '_', $str);			
			$str = preg_replace('/-/', '_', $str);			
			$str = preg_replace('/[áàãâä]/ui', 'a', $str);
			$str = preg_replace('/[éèêë]/ui', 'e', $str);
			$str = preg_replace('/[íìîï]/ui', 'i', $str);
			$str = preg_replace('/[óòõôö]/ui', 'o', $str);
			$str = preg_replace('/[úùûü]/ui', 'u', $str);
			$str = preg_replace('/[ç]/ui', 'c', $str);
			$str = preg_replace('/[^._a-z0-9]/i', '', $str);
			return strtolower($str);
    }


	public static function ToUpper($text)
	{
		$text = strtoupper($text);
		$text = str_replace("ç", "Ç", $text);
		$text = str_replace("â", "Â", $text);
		$text = str_replace("ã", "Ã", $text);
		$text = str_replace("á", "Á", $text);
		$text = str_replace("à", "À", $text);
		$text = str_replace("é", "É", $text);
		$text = str_replace("ê", "Ê", $text);
		$text = str_replace("í", "Í", $text);
		$text = str_replace("ó", "Ó", $text);
		$text = str_replace("õ", "Õ", $text);
		$text = str_replace("ô", "Ô", $text);
		$text = str_replace("ú", "Ú", $text);

		return $text;
	}

	public static function ToLower($text)
	{
		$text = strtolower($text);
		$text = str_replace("Ç", "ç", $text);
		$text = str_replace("Â", "â", $text);
		$text = str_replace("Ã", "ã", $text);
		$text = str_replace("Á", "á", $text);
		$text = str_replace("À", "à", $text);
		$text = str_replace("É", "é", $text);
		$text = str_replace("Ê", "ê", $text);
		$text = str_replace("Í", "í", $text);
		$text = str_replace("Ó", "ó", $text);
		$text = str_replace("Õ", "õ", $text);
		$text = str_replace("Ô", "ô", $text);
		$text = str_replace("Ú", "ú", $text);

		return $text;
	}


	public static function DiffBetweenDates($initialDate, $finalDate, $round = 0)
	{
		$difference = 0;

		$initialDate = strtotime($initialDate);
		$finalDate = strtotime($finalDate);

		$difference = ($finalDate - $initialDate) / 86400;

		if ($round != 0)
			return floor($difference);
		else
			return $difference;
	}


	public static function CalcAge($day, $month, $year)
    {
		if ($year >= 1970)
        {
			$day0 = mktime(0,0,0,$month,$day,$year);
			$day1 = mktime(0,0,0,date("m"),date("d"),date("Y"));
			$datef = $day1 - $day0;
			$datef /= 86400;
			$datef /= 365.5;
			$datef  = floor($datef);
		}
        else
        {
			$yearrest = 1970 - $year;
			$year   = 1970;
			$day0 = mktime(0,0,0,$month,$day,$year);
			$day1 = mktime(0,0,0,date("m"),date("d"),date("Y"));
			$datef = $day1 - $day0;
			$datef /= 86400;
			$datef /= 365.5;
			$datef  = floor($datef);
			$datef += $yearrest;
		}

		if ($datef < 18)
        {
			$datef = 18;
		}

		return $datef;
	}

    public static function GetCurrentDate()
    {		
        $timestamp = mktime(date("H") - (-(SITE_TIMEFIX)), date("i"), date("s"), date("m"), date("d"), date("Y"));
        return gmdate("Y-m-d H:i:s", $timestamp);
    }

	public static function GetMyDate($field,$type)
    {
		$result = null;

		if(isset($field) && !is_null($field) && ($field <> "1900-01-01 00:00:00") && ($field <> "1901-01-01 00:00:00"))
		{

			switch($type){
				case "1": $result = strftime("%d/%m/%y",strtotime($field)); break;
				case "1x": $result = strftime("%d/%m/%Y",strtotime($field)); break;
				case "2": $result = strftime("%d/%m/%Y %H:%M",strtotime($field)); break;
				case "2x": $result = strftime("%d/%m/%Y %H:%M",strtotime($field)); break;
				case "3": $result = strftime("%d-%m-%y | %Hh%Mm",strtotime($field)); break;
				case "3x": $result = strftime("%Y-%m-%d",strtotime($field)); break;
				case "3z": $result = strftime("%Y-%m-%d %H:%m:00",strtotime($field)); break;
				case "4": $result = strftime("%d.%m",strtotime($field)); break;
				case "5": $result = strftime("%Hh%Mm",strtotime($field)); break;
				case "6": $result = strftime("%Hh%Mm",strtotime($field)); break;
				case "day": $result = strftime("%d",strtotime($field)); break;
				case "month": $result = strftime("%m",strtotime($field)); break;
				case "year": $result = strftime("%Y",strtotime($field)); break;
				case "idade": $result = strftime("%d,%m,%Y",strtotime($field)); break;

			}
		}

		return $result;
	}

	public static function GetPostAge($date)
	{
		$CI =& get_instance();
		$CI->load->helper('date');
		$CI->load->library('calendar');
		$CI->load->helper('language');

		$firstDate = strtotime(self::getCurrentDate());
		$finalDate = strtotime($date);

		$difference = ($firstDate - $finalDate) / 86400;
		if ($difference <= 6)
		{
			$arrayTimeSpan = explode(",", timespan($finalDate, $firstDate));
			return $CI->lang->line('IdadePost_ha')." ".$arrayTimeSpan[0];
		}
		else
		{
			$strPostAge = "";
			$arrayDate = explode("-", date("Y-m-d", $finalDate));

			$strPostAge = $arrayDate[2]." ".$CI->lang->line('IdadePost_de')." ".$CI->calendar->get_month_name($arrayDate[1]);
			($arrayDate[0] != date("Y")) ? $strPostAge .= " de ".$arrayDate[0] : "";
			$strPostAge .= ", ".$CI->lang->line('IdadePost_as')." ".date("H:i", $finalDate);

			return $strPostAge;
		}
	}

	/**
	* getFileType($fileName)
	* Verifica se o arquivo é um video ou uma imagem
	* @param string $fileName Nome do arquivo
	* @return string VIDEO se vídeo e IMAGEM se for uma foto
	*/
	public static function GetFileType($fileName) 
    {
		$ext = self::ToLower(self::getFileExtention($fileName));

		$aVideosExtentions  = explode(';', str_replace('*.','',VIDEO_ALLOW_EXTENTIONS));
		$aImagensExtentions = explode(';', str_replace('*.','',IMAGE_ALLOW_EXTENTIONS));
		$aAudioExtentions   = explode(';', str_replace('*.','',AUDIO_ALLOW_EXTENTIONS));

		if(array_search($ext, $aVideosExtentions) !== false)
		return 'VIDEO';
		else if(array_search($ext, $aImagensExtentions) !== false)
		return 'IMAGEM';
		else if(array_search($ext, $aAudioExtentions) !== false)
		return 'AUDIO';
		else
		return 'UNDEFINED';
	}

	/**
	* @static
	* @method FormatDate
	* @param string
	* @return string
	* @desc Formata uma string no padrao que deve ser gravado no banco de dados
	*/
	public static function FormatDate($date)
	{
		$result = null;

		if(isset($date) && !empty($date))
		{
			$result = implode("-",array_reverse(explode('/', $date)));
		}

		return $result;
	}

	/**
	 * getFileExtention($fileName)
	 * Retorna a extensão da imagem
	 * @param string $fileName Nome do arquivo
	 * @return string Extensão do arquivo
	 */
	public static function GetFileExtention($fileName) 
    {

		$ext = explode('.', $fileName);
		return end($ext);

	}

	//função para remover palavras que contenhas termos sql
	public static function NoInjection($sql)
    {
		// remove palavras que contenham sintaxe sql
		$sql = preg_replace("/(select|Select|SELECT|insert|Insert|INSERT|delete|Delete|DELETE|where|drop |Drop |DROP |drop\/|Drop\/|DROP\/|drop table|show tables|--|\\\\)/i","",$sql);
		$sql = trim($sql);//limpa espaços vazio
		$sql = strip_tags($sql);//tira tags html e php
		$sql = addslashes($sql);//Adiciona barras invertidas a uma string
		return $sql;
	}

	public static function ClearStringContacts($str, $clearUrl = TRUE)
	{
		if (!empty($str))
		{
			$str = preg_replace('/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/imx', '...', $str);

			if ($clearUrl)
			{
				$str = preg_replace('/\b[https?\:\/\/|(\w){3}?]+\.{1}?[A-Z0-9.-]+\.[A-Z]{2,4}\b/imx', '...', $str);
			}

			$keywords = array(
				'@',
				'(a)',
				'( a )',
				'arroba',
				'a r r o b a',
				'a.r.r.o.b.a',
				'arrouba',
				'a r r o u b a',
				'a.r.r.o.u.b.a',
				'aroba',
				'a r o b a',
				'a.r.o.b.a',
				'hot',
				'h o t',
				'hotmail',
				'h o t m a i l',
				'h.o.t.m.a.i.l',
				'h=o=t=m=a=i=l',
				'h_o_t_m_a_i_l',
				'h-o-t-m-a-i-l',
				'h = o = t = m = a = i = l',
				'rotmail',
				'r o t m a i l',
				'r.o.t.m.a.i.l',
				'r=o=t=m=a=i=l',
				'r_o_t_m_a_i_l',
				'r-o-t-m-a-i-l',
				'r = o = t = m = a = i = l',
				'rotmeio',
				'r o t m e i o',
				'r.o.t.m.e.i.o',
				'gmail',
				'g m a i l',
				'g.m.a.i.l',
				'mail',
				'm a i l',
				'm.a.i.l',
				'yahoo',
				'y a h o o',
				'y.a.h.o.o',
				'_ponto_',
				'(ponto)',
				'(p_o_n_t_o)',
				'(p-o-n-t-o)'
			);

			if ($clearUrl)
			{
				array_push($keywords,
					'h t t p : / /',
					'http',
					'http://',
					'://',
					'w w w',
					'www',
					'www.',
					'w w w .',
					'.com.br',
					'.c.o.m.b.r',
					'. c o m . b r',
					'.com',
					'c.o.m',
					'c o m',
					'. b r',
					'.gov',
					'g o v'
				);
			}

			$str = str_ireplace($keywords, '...', $str);
			return $str;

		}
		else
		{
			return NULL;
		}
	}

	/**
	 * CleanMyField($field) Remove tags html e aspas de uma variável
	 * @param string $field Campo a ser filtrado
	 * @return string Campo tratado
	 */
	public function CleanMyField($field)
	{
		$field = str_replace("'", "&#039;", "$field");
		$field = str_replace('"', "&quot;", "$field");
		$field = strip_tags($field);

		return $field;
	}

	public static function FormatLongText($text, $maxSize, $endString = '...') 
    {

		if(mb_detect_encoding($text) == 'UTF-8')
			$encoding = 'UTF-8';
		else
			$encoding = 'ISO-8859-1';

		$text = html_entity_decode($text, ENT_COMPAT, $encoding);

		if(strlen($text) > $maxSize)
			$text = substr($text, 0, ($maxSize-3)) . $endString;

		return htmlentities($text, ENT_COMPAT, $encoding);

	}

	public static  function FormatLongWords($text, $maxSize) 
    {

		$aWords = explode(' ', $text);

		foreach($aWords as $key => $word){

			if(strlen($word) > $maxSize)
				$aWords[$key] = substr($word, 0, ($maxSize-4)) . '...' . substr($word, -1);
			else
				$aWords[$key] = $word;
		}

		return implode(' ', $aWords);

	}

	/**
	 * @static
	 * @method IsValidAge
	 * @param string
	 * @return boolean
	 * @desc Verifica se é maior de 18 anos
	 */

	public static function IsValidAge($birthday)
	{
		list($day,$month,$year) = explode('/', $birthday);

		if ($year >= 1970){
			$day0 = mktime(0,0,0,$month,$day,$year);
			$day1 = mktime(0,0,0,date("m"),date("d"),date("Y"));
			$datef = $day1 - $day0;
			$datef /= 86400;
			$datef /= 365.5;
			$datef  = floor($datef);
		}else{
			$yearrest = 1970 - $year;
			$year   = 1970;
			$day0 = mktime(0,0,0,$month,$day,$year);
			$day1 = mktime(0,0,0,date("m"),date("d"),date("Y"));
			$datef = $day1 - $day0;
			$datef /= 86400;
			$datef /= 365.5;
			$datef  = floor($datef);
			$datef += $yearrest;
		}

		if ($datef < 18){
			return false;
		}

		return true;
	}

	/**
	 * @static
	 * @method IsValidEmail
	 * @param string
	 * @return boolean
	 * @desc Verifica se o email é válido
	*/
	public static function IsValidEmail($email)
	{
		$count		= "^[a-zA-Z0-9\._-]+@";
		$domain		= "[a-zA-Z0-9\._-]+.";
		$extension	= "([a-zA-Z]{2,4})$^";

		$pattern = $count.$domain.$extension;

		if (preg_match($pattern, $email))
		{
			$arrayEmail = explode('@', $email);
			$arrayKeyName = array('teste');

			foreach($arrayKeyName as $value)
			{
				if ($arrayEmail[0] == $value)
				{
					return false;
				}
			}

			return true;
		}
		else
		{
			return false;
		}

	}


	public static function Equals($value1, $value2)
	{
		$result = FALSE;

		if($value1 == $value2)
		{
			$result = TRUE;
		}

		return $result;
	}

	public static function NoEquals($value1, $value2)
	{
		$result = FALSE;

		if($value1 != $value2)
		{
			$result = TRUE;
		}

		return $result;
	}

	public function ConvertWord($term, $tp)
	{
		if ($tp == "1") $palavra = strtr(strtoupper($term),"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
		elseif ($tp == "0") $palavra = strtr(strtolower($term),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
		return $palavra;
	}

	public static function ShowTab($parameters)
	{
		$result = null;

		if(!is_null($parameters) && !empty($parameters) && count($parameters) > 0)
		{
			$result = "<div class='oTab'>";
			$js     = "\n<script type='text/javascript'>
							function fJS_HideTabs()
							{
							";
			$fist = null;
			foreach($parameters as $name => $value)
			{
				if(is_null($fist) || empty($fist))$fist = $name;

				$js .= "$('#".$name."').hide();\n";
			}
				$js.="
							}
							\n
							$(document).ready(function() {
								fJS_HideTabs();
								$('#".$fist."').show();
			          ";

			foreach($parameters as $name => $value)
			{
			  		$result .="
								<div class='oTab_L'>
									&nbsp;
								</div>
								<div class='oTab_B' id='tab_".$name."'>
									$value
								</div>
								<div class='oTab_R'>
									&nbsp;
								</div>";

			  		$js .= "$('#tab_".$name."').click(function(){
								fJS_HideTabs();
								$('#".$name."').show();
							});";
			}

			$result .= "</div>";
			$js     .= "});
			            </script>";
		}

		return  $result.$js;
	}

	public static function RevertXssFilterForObject($str)
	{
		$str   = str_replace('&lt;object', '<object', $str);
		$str   = str_replace('&gt;&lt;param', '><param', $str);
		$str   = str_replace('&lt;embed', '<embed', $str);
		$str   = str_replace('&gt;&lt;/embed>&lt;/object&gt;&lt;', '></embed></object><', $str);
		$str   = str_replace('&gt;&lt;/embed>&lt;/object&gt;', '></embed></object>', $str);
		$str   = str_replace('&lt;iframe', '<iframe', $str);
		$str   = str_replace('&gt;&lt;/iframe>', '></iframe>', $str);

		return $str;
	}
	
	
	/**
	 * @static
	 * @method DiffHour
	 * @param string
	 * @return string
	 * @desc Retorna a diferenca entre as horas
	*/
	
	public function DiffHour($hour1, $hour2) 
	{
		$timestamp1 = strtotime($hour1);
		$timestamp2 = strtotime($hour2);

		if ($timestamp2 < $timestamp1) 
		{
			return NULL;
		}
		
		$diff = $timestamp2 - $timestamp1;
		
		$hours		= floor($diff / 3600);
		$minutes	= floor($diff % 3600 / 60);
		$seconds	= $diff % 60;
				
		return sprintf("%d:%02d:%02d", $hours, $minutes, $seconds);
	}
	
	public function ArrayToObject($array)
	{
		$obj = new Object();
		
		if(self::IsValidArray($array))
		{
			foreach ($array as $key=>$value)
			{
				$obj->$key = $value;
			}
		}
		
		return $obj;
	}
	
	public static function ParamsToString($text, $array)
	{
		if (!(is_array($array)))
		{
			$valueAux = $array;
			$array = NULL;
			$array[] = $valueAux;
		}

		foreach ($array as $key => $value)
		{
			$pos = strpos($text, '{' . $key . '}');
			if (!($pos === false))
			{
				$ant = substr($text, 0, $pos);
				$prox = substr($text, $pos + 3, strlen($text) - $pos - 3);

				$text = $ant . $value . $prox;
			}
		}

		return $text;
	}
        
    public static function StatusToString($value)
    {
		$CI =& get_instance();

        $result = $CI->lang->line('Inactive'); // "Inativo";
        
        if((string)$value == 't' || (int)$value == 1)
        {
            $result = $CI->lang->line('Active'); // "Ativo";                
        }
        
        return $result;
    }
        
    public static function TruncateHtml($text,$numb) 
    {
        // source: www.kigoobe.com, please keep this if you are using the function
        $text = html_entity_decode($text, ENT_QUOTES);
        if (strlen($text) > $numb) 
        {
            $text = substr($text, 0, $numb);
            $text = substr($text,0,strrpos($text," "));
            $etc = " ..."; 
            $text = $text.$etc;
        } 
        $text = htmlentities($text, ENT_QUOTES); 
        return $text;
    }


	public static function SetLabelByStatus($status)
	{
		$result = "";
		$CI =& get_instance();

		if((string)$status == 't' || (int)$status == 1)
		{
			$result = '<span class="label label-success fs11 text-bold cursor-default">'.$CI->lang->line("Active").'</span>';
		}
		else
		{
			$result = '<span class="label label-danger fs11 text-bold cursor-default">'.$CI->lang->line("Inactive").'</span>';
		}

		return $result;
	}

	public static function SetCallActionStatus($status, $id, $triggerJS)
	{
		$result = "";
		$CI =& get_instance();

		if((string)$status == 't' || (int)$status == 1)
		{
			$result = '<a href="javascript:void(0);" onclick="javascript:'.$triggerJS.'('.$id.',0);"  data-toggle="tooltip" data-placement="top" title="'. $CI->lang->line("InactivateRecord").'"><i class="glyphicons glyphicons-circle_minus text-danger"></i></a>';
		}
		else
		{
			$result = '<a href="javascript:void(0);" onclick="javascript:'.$triggerJS.'('.$id.',1);"  data-toggle="tooltip" data-placement="top" title="'. $CI->lang->line("ActivateRecord").'"><i class="glyphicons glyphicons-circle_plus text-success"></i></a>';
		}

		return $result;
	}

	public static function GetCssTextByStatus($status)
	{
		$result = "";

 		if((string)$status == 't' || (int)$status > 0)
		{
			$result = "text-default";
		}
		else $result = "text-danger";

		return $result;
	}

	public static function CastStatus($status, $IsSetToDB = FALSE)
	{
		$result = 0;

		$CI =& get_instance();

		if((string)$status == 't' || (int)$status == 1)
		{
			if($IsSetToDB)
			{
				if($CI->db->platform() == 'postgre')
				{
					$result = 't';
				}
				else $result = 1;
			}
			else $result = 1;
		}
		else
		{
			if($IsSetToDB)
			{
				if($CI->db->platform() == 'postgre')
				{
					$result = 'f';
				}
				else $result = 0;
			}
			else $result = 0;
		}

		return $result;
	}

	public static function FormatCodeToURL($id, $sizeInternalCode=6)
	{
		return base64_encode(self::FormatCode($id,$sizeInternalCode));
	}

	public static function FormatMoney($money, $language="pt-BR")
	{
		//setlocale(LC_ALL,"pt_BR","ptb","portuguese-brazil","bra","brazil","pt_BR.utf-8","br","pt_BR.iso-8859-1");
		$result = null;

		switch($language)
		{
			case "pt-BR": $result = 'R$ ' . number_format($money, 2, ',', '.'); break;
			case "es-Es":
			case "en-US":
				$result = 'U$' . number_format($num, 2, '.', ',');
			break;
							
			default: $result = 'R$ ' . number_format($money, 2, ',', '.'); break;
		}

		return $result;
	}

	public static function SortArray($array, $on, $order=SORT_ASC)
	{
		$new_array = array();
		$sortable_array = array();

		if (count($array) > 0) {
			foreach ($array as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $k2 => $v2) {
						if ($k2 == $on) {
							$sortable_array[$k] = $v2;
						}
					}
				} else {
					$sortable_array[$k] = $v;
				}
			}

			switch ($order) {
				case SORT_ASC:
					asort($sortable_array);
				break;
				case SORT_DESC:
					arsort($sortable_array);
				break;
			}

			foreach ($sortable_array as $k => $v) {
				$new_array[$k] = $array[$k];
			}
		}

		return $new_array;
	}

	//GENERATE RANDOM PASSWORD
	public static function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}
	
	public static function ApagaDir($dir) {
		if($objs = glob($dir."/*")){
			foreach($objs as $obj) {
				is_dir($obj)? Tools::ApagaDir($obj) : unlink($obj);
			}
		}
		rmdir($dir);
	} 		
	
}
?>
