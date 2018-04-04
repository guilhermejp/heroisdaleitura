<?php
/**
 * @author JE
 * Class Security
 * Type: Helpers
 */
class Security
{
	/**
     * @static
     * @method GenerateHash($type, $value)
     * @param string, string
     * @return string
     * @desc Gera uma string no padrão do hash informado. (PHP 5 >= 5.1.2, PECL hash >= 1.1)
     */
	private static function GenerateHash($type, $value, $binary=FALSE)
	{
		$result = "";
		
		//--> return format binary
		if($binary)
		{			
			$result = hash($type, $value, TRUE);
		}
		else $result = hash($type, $value);
		
		return $result;
	}

	/**
     * @static
     * @method GenerateMD5($value)
     * @param string
     * @return string
     * @desc Gera uma string no padrão MD5
     */
	public static function GenerateMD5($value)
	{
		return self::GenerateHash('md5', $value);
	}

	/**
     * @static
     * @method GenerateSha1($value)
     * @param string
     * @return string
     * @desc Gera uma string no padrão SHA1
     */
	public static function GenerateSha1($value)
	{
		return self::GenerateHash('sha1', $value);
	}

	/**
     * @static
     * @method GenerateSha384($value)
     * @param string
     * @return string
     * @desc Gera uma string no padrão SHA384
     */
	public static function GenerateSha384($value)
	{
		return self::GenerateHash('sha384', $value);
	}

	/**
     * @static
     * @method GenerateSha512($value)
     * @param string
     * @return string
     * @desc Gera uma string no padrão SHA512
     */
	public static function GenerateSha512($value, $binary=FALSE)
	{
		$result = "";
		
		if($binary)
		{
			$result = base64_encode(self::GenerateHash('sha512', $value, TRUE));
		}
		else $result = self::GenerateHash('sha512', $value);
		
		return $result;
	}

	/**
     * @static
     * @method GenerateCRC32($value)
     * @param string
     * @return string
     * @desc Gera uma string no padrão CRC32
     */
	public static function GenerateCRC32($value)
	{
		return self::GenerateHash('crc32', $value);
	}
}