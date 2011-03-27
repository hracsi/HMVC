<?php

/**
 * This class has been taken from CakePHP - http://book.cakephp.org/view/1478/Inflector
 * 
 * @copyright     Copyright 2010, Hracsi's MVC Project http://hracsi.net
 * @package       hmvc
 * @subpackage    hmvc.core
 * @since         hmvc (tm) v. 0.2.0.0
 * @version       hmvc (tm) v. 0.7.5.6
 * 
 */

class Inflector {

	public $_plural = array(
		'rules' => array(
			'/(s)tatus$/i' => '\1\2tatuses',
			'/(quiz)$/i' => '\1zes',
			'/^(ox)$/i' => '\1\2en',
			'/([m|l])ouse$/i' => '\1ice',
			'/(matr|vert|ind)(ix|ex)$/i'  => '\1ices',
			'/(x|ch|ss|sh)$/i' => '\1es',
			'/([^aeiouy]|qu)y$/i' => '\1ies',
			'/(hive)$/i' => '\1s',
			'/(?:([^f])fe|([lr])f)$/i' => '\1\2ves',
			'/sis$/i' => 'ses',
			'/([ti])um$/i' => '\1a',
			'/(p)erson$/i' => '\1eople',
			'/(m)an$/i' => '\1en',
			'/(c)hild$/i' => '\1hildren',
			'/(buffal|tomat)o$/i' => '\1\2oes',
			'/(alumn|bacill|cact|foc|fung|nucle|radi|stimul|syllab|termin|vir)us$/i' => '\1i',
			'/us$/' => 'uses',
			'/(alias)$/i' => '\1es',
			'/(ax|cris|test)is$/i' => '\1es',
			'/s$/' => 's',
			'/^$/' => '',
			'/$/' => 's',
		),
		'uninflected' => array(
			'.*[nrlm]ese', '.*deer', '.*fish', '.*measles', '.*ois', '.*pox', '.*sheep', 'people'
		),
		'irregular' => array(
			'atlas' => 'atlases',
			'beef' => 'beefs',
			'brother' => 'brothers',
			'child' => 'children',
			'corpus' => 'corpuses',
			'cow' => 'cows',
			'ganglion' => 'ganglions',
			'genie' => 'genies',
			'genus' => 'genera',
			'graffito' => 'graffiti',
			'hoof' => 'hoofs',
			'loaf' => 'loaves',
			'man' => 'men',
			'money' => 'monies',
			'mongoose' => 'mongooses',
			'move' => 'moves',
			'mythos' => 'mythoi',
			'niche' => 'niches',
			'numen' => 'numina',
			'occiput' => 'occiputs',
			'octopus' => 'octopuses',
			'opus' => 'opuses',
			'ox' => 'oxen',
			'penis' => 'penises',
			'person' => 'people',
			'sex' => 'sexes',
			'soliloquy' => 'soliloquies',
			'testis' => 'testes',
			'trilby' => 'trilbys',
			'turf' => 'turfs'
		)
	);

	public $_singular = array(
		'rules' => array(
			'/(s)tatuses$/i' => '\1\2tatus',
			'/^(.*)(menu)s$/i' => '\1\2',
			'/(quiz)zes$/i' => '\\1',
			'/(matr)ices$/i' => '\1ix',
			'/(vert|ind)ices$/i' => '\1ex',
			'/^(ox)en/i' => '\1',
			'/(alias)(es)*$/i' => '\1',
			'/(alumn|bacill|cact|foc|fung|nucle|radi|stimul|syllab|termin|viri?)i$/i' => '\1us',
			'/([ftw]ax)es/i' => '\1',
			'/(cris|ax|test)es$/i' => '\1is',
			'/(shoe|slave)s$/i' => '\1',
			'/(o)es$/i' => '\1',
			'/ouses$/' => 'ouse',
			'/([^a])uses$/' => '\1us',
			'/([m|l])ice$/i' => '\1ouse',
			'/(x|ch|ss|sh)es$/i' => '\1',
			'/(m)ovies$/i' => '\1\2ovie',
			'/(s)eries$/i' => '\1\2eries',
			'/([^aeiouy]|qu)ies$/i' => '\1y',
			'/([lr])ves$/i' => '\1f',
			'/(tive)s$/i' => '\1',
			'/(hive)s$/i' => '\1',
			'/(drive)s$/i' => '\1',
			'/([^fo])ves$/i' => '\1fe',
			'/(^analy)ses$/i' => '\1sis',
			'/(analy|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i' => '\1\2sis',
			'/([ti])a$/i' => '\1um',
			'/(p)eople$/i' => '\1\2erson',
			'/(m)en$/i' => '\1an',
			'/(c)hildren$/i' => '\1\2hild',
			'/(n)ews$/i' => '\1\2ews',
			'/eaus$/' => 'eau',
			'/^(.*us)$/' => '\\1',
			'/s$/i' => ''
		),
		'uninflected' => array(
			'.*[nrlm]ese', '.*deer', '.*fish', '.*measles', '.*ois', '.*pox', '.*sheep', '.*ss'
		),
		'irregular' => array(
			'waves' => 'wave'
		)
	);

	public $_uninflected = array(
		'Amoyese', 'bison', 'Borghese', 'bream', 'breeches', 'britches', 'buffalo', 'cantus',
		'carp', 'chassis', 'clippers', 'cod', 'coitus', 'Congoese', 'contretemps', 'corps',
		'debris', 'diabetes', 'djinn', 'eland', 'elk', 'equipment', 'Faroese', 'flounder',
		'Foochowese', 'gallows', 'Genevese', 'Genoese', 'Gilbertese', 'graffiti',
		'headquarters', 'herpes', 'hijinks', 'Hottentotese', 'information', 'innings',
		'jackanapes', 'Kiplingese', 'Kongoese', 'Lucchese', 'mackerel', 'Maltese', 'media',
		'mews', 'moose', 'mumps', 'Nankingese', 'news', 'nexus', 'Niasese',
		'Pekingese', 'Piedmontese', 'pincers', 'Pistoiese', 'pliers', 'Portuguese',
		'proceedings', 'rabies', 'rice', 'rhinoceros', 'salmon', 'Sarawakese', 'scissors',
		'sea[- ]bass', 'series', 'Shavese', 'shears', 'siemens', 'species', 'swine', 'testes',
		'trousers', 'trout','tuna', 'Vermontese', 'Wenchowese', 'whiting', 'wildebeest',
		'Yengeese'
	);

	public $_transliteration = array(
		'/ä|a|?/' => 'ae',
		'/ö|o/' => 'oe',
		'/ü/' => 'ue',
		'/Ä/' => 'Ae',
		'/Ü/' => 'Ue',
		'/Ö/' => 'Oe',
		'/A|Á|Â|A|Ä|A|?|A|Ã|¥|A/' => 'A',
		'/a|á|â|a|a|?|a|ã|¹|a|a/' => 'a',
		'/Ç|Æ|C|C|È/' => 'C',
		'/ç|æ|c|c|è/' => 'c',
		'/?|Ï|Ð/' => 'D',
		'/?|ï|ð/' => 'd',
		'/E|É|E|Ë|E|E|E|Ê|Ì/' => 'E',
		'/e|é|e|ë|e|e|e|ê|ì/' => 'e',
		'/G|G|G|G/' => 'G',
		'/g|g|g|g/' => 'g',
		'/H|H/' => 'H',
		'/h|h/' => 'h',
		'/I|Í|Î|I|I|I|I|I|I|I/' => 'I',
		'/i|í|î|i|i|i|i|i|i|i/' => 'i',
		'/J/' => 'J',
		'/j/' => 'j',
		'/K/' => 'K',
		'/k/' => 'k',
		'/Å|L|¼|?|£/' => 'L',
		'/å|l|¾|?|³/' => 'l',
		'/N|Ñ|N|Ò/' => 'N',
		'/n|ñ|n|ò|?/' => 'n',
		'/O|Ó|Ô|O|O|O|O|Õ|O|O|?/' => 'O',
		'/o|ó|ô|o|o|o|o|õ|o|o|?|o/' => 'o',
		'/À|R|Ø/' => 'R',
		'/à|r|ø/' => 'r',
		'/Œ|S|ª|Š/' => 'S',
		'/œ|s|º|š|?/' => 's',
		'/Þ||T/' => 'T',
		'/þ||t/' => 't',
		'/U|Ú|U|U|U|U|Ù|Û|U|U|U|U|U|U|U/' => 'U',
		'/u|ú|u|u|u|u|ù|û|u|u|u|u|u|u|u/' => 'u',
		'/Ý|Y|Y/' => 'Y',
		'/ý|y|y/' => 'y',
		'/W/' => 'W',
		'/w/' => 'w',
		'/|¯|Ž/' => 'Z',
		'/Ÿ|¿|ž/' => 'z',
		'/A|?/' => 'AE',
		'/ß/'=> 'ss',
		'/?/' => 'IJ',
		'/?/' => 'ij',
		'/O/' => 'OE',
		'/f/' => 'f'
	);

	public $_pluralized = array();
	public $_singularized = array();
	public $_underscore = array();
	public $_camelize = array();
	public $_tableize = array();

	public function &getInstance()
    {
		static $instance = array();

		if (!$instance) {
			$instance[0] =& new Inflector();
		}
		return $instance[0];
	}

	private function _cache($type, $key, $value = false)
    {
		$key = '_' . $key;
		$type = '_' . $type;
		if ($value !== false) {
			$this->{$type}[$key] = $value;
			return $value;
		}

		if (!isset($this->{$type}[$key])) {
			return false;
		}
		return $this->{$type}[$key];
	}

	private function rules($type, $rules, $reset = false)
    {
		$_this =& Inflector::getInstance();
		$public = '_'.$type;

		switch ($type) {
			case 'transliteration':
				if ($reset) {
					$_this->_transliteration = $rules;
				} else {
					$_this->_transliteration = $rules + $_this->_transliteration;
				}
			break;

			default:
				foreach ($rules as $rule => $pattern) {
					if (is_array($pattern)) {
						if ($reset) {
							$_this->{$var}[$rule] = $pattern;
						} else {
							$_this->{$var}[$rule] = array_merge($pattern, $_this->{$var}[$rule]);
						}
						unset($rules[$rule], $_this->{$var}['cache' . ucfirst($rule)]);
						if (isset($_this->{$var}['merged'][$rule])) {
							unset($_this->{$var}['merged'][$rule]);
						}
						if ($type === 'plural') {
							$_this->_pluralized = $_this->_tableize = array();
						} elseif ($type === 'singular') {
							$_this->_singularized = array();
						}
					}
				}
				$_this->{$var}['rules'] = array_merge($rules, $_this->{$var}['rules']);
			break;
		}
	}

	public function pluralize($word)
    {
		$_this =& Inflector::getInstance();

		if (isset($_this->_pluralized[$word])) {
			return $_this->_pluralized[$word];
		}

		if (!isset($_this->_plural['merged']['irregular'])) {
			$_this->_plural['merged']['irregular'] = $_this->_plural['irregular'];
		}

		if (!isset($_this->plural['merged']['uninflected'])) {
			$_this->_plural['merged']['uninflected'] = array_merge($_this->_plural['uninflected'], $_this->_uninflected);
		}

		if (!isset($_this->_plural['cacheUninflected']) || !isset($_this->_plural['cacheIrregular'])) {
			$_this->_plural['cacheUninflected'] = '(?:' . implode('|', $_this->_plural['merged']['uninflected']) . ')';
			$_this->_plural['cacheIrregular'] = '(?:' . implode('|', array_keys($_this->_plural['merged']['irregular'])) . ')';
		}

		if (preg_match('/(.*)\\b(' . $_this->_plural['cacheIrregular'] . ')$/i', $word, $regs)) {
			$_this->_pluralized[$word] = $regs[1] . substr($word, 0, 1) . substr($_this->_plural['merged']['irregular'][strtolower($regs[2])], 1);
			return $_this->_pluralized[$word];
		}

		if (preg_match('/^(' . $_this->_plural['cacheUninflected'] . ')$/i', $word, $regs)) {
			$_this->_pluralized[$word] = $word;
			return $word;
		}

		foreach ($_this->_plural['rules'] as $rule => $replacement) {
			if (preg_match($rule, $word)) {
				$_this->_pluralized[$word] = preg_replace($rule, $replacement, $word);
				return $_this->_pluralized[$word];
			}
		}
	}

	public function singularize($word) {
		$_this =& Inflector::getInstance();

		if (isset($_this->_singularized[$word])) {
			return $_this->_singularized[$word];
		}

		if (!isset($_this->_singular['merged']['uninflected'])) {
			$_this->_singular['merged']['uninflected'] = array_merge($_this->_singular['uninflected'], $_this->_uninflected);
		}

		if (!isset($_this->_singular['merged']['irregular'])) {
			$_this->_singular['merged']['irregular'] = array_merge($_this->_singular['irregular'], array_flip($_this->_plural['irregular']));
		}

		if (!isset($_this->_singular['cacheUninflected']) || !isset($_this->_singular['cacheIrregular'])) {
			$_this->_singular['cacheUninflected'] = '(?:' . join( '|', $_this->_singular['merged']['uninflected']) . ')';
			$_this->_singular['cacheIrregular'] = '(?:' . join( '|', array_keys($_this->_singular['merged']['irregular'])) . ')';
		}

		if (preg_match('/(.*)\\b(' . $_this->_singular['cacheIrregular'] . ')$/i', $word, $regs)) {
			$_this->_singularized[$word] = $regs[1] . substr($word, 0, 1) . substr($_this->_singular['merged']['irregular'][strtolower($regs[2])], 1);
			return $_this->_singularized[$word];
		}

		if (preg_match('/^(' . $_this->_singular['cacheUninflected'] . ')$/i', $word, $regs)) {
			$_this->_singularized[$word] = $word;
			return $word;
		}

		foreach ($_this->_singular['rules'] as $rule => $replacement) {

			if (preg_match($rule, $word)) {
				$_this->_singularized[$word] = preg_replace($rule, $replacement, $word);
				return $_this->_singularized[$word];
			}
		}
		$_this->_singularized[$word] = $word;
		return $word;
	}
    
	public function underscore($camelCasedWord)
    {
		$_this =& Inflector::getInstance();
		if (!($result = $_this->_cache(__FUNCTION__, $camelCasedWord))) {
			$result = strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $camelCasedWord));
			$_this->_cache(__FUNCTION__, $camelCasedWord, $result);
		}
		return $result;
	}
    
    public function antiScore($str)
    {
        for($i=0; $i <= strlen($str); $i++ ) {
            if ( $str[$i] == '_' ) {
                $str[$i+1] = strtoupper($str[$i+1]);
                continue; 
            }
            $str2[$i] = $str[$i];
        }
        return implode($str2);
    }
  	
    public function camelize($str)
    {
        return ucwords($str);
    }
    
    public function escape($str)
    {
        return str_replace(array('controller','class'),'',strToLower($str));    
    }
        
    public function makeSqlTableName($str)
    {
        return self::underscore(self::pluralize(self::escape($str)));
    }
    
    public function makeControllerName($str)
    {
    	return self::pluralize(self::camelize(self::escape(self::antiScore($str)))) . 'Controller';
    }
    
    public function makeModelName($str)
    {
    	return self::camelize(self::singularize(self::escape($str)));
    }
    

}