<?php
/**
* @version		$Id: countries.php 5205 2010-09-24 08:00:00Z
* @package		JoomlaLeague
* @copyright	Copyright (C) 2008 Julien Vonthron. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla Tracks is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class Countriesdiddipoeler
{
	// Hints:
	// http://en.wikipedia.org/wiki/List_of_FIFA_country_codes
	// http://en.wikipedia.org/wiki/Comparison_of_IOC,_FIFA,_and_ISO_3166_country_codes
	// http://en.wikipedia.org/wiki/Category:Country_codes
	// http://en.wikipedia.org/wiki/ISO_3166-1
	// http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
	// http://en.wikipedia.org/wiki/ISO_3166-1_alpha-3
	// http://en.wikipedia.org/wiki/ISO_3166-1_numeric
	//
	function getCountries()
	{
		$country["AFG"]= Array("iso2" => "AF", "name" => "AFGHANISTAN, ISLAMIC REPUBLIC");
		$country["ALA"]= Array("iso2" => "AX", "name" => "ÅLAND ISLANDS");
		$country["ALB"]= Array("iso2" => "AL", "name" => "ALBANIA, REPUBLIC OF");
		$country["DZA"]= Array("iso2" => "DZ", "name" => "ALGERIA, PEOPLE'S DEMOCRATIC REPUBLIC");
		$country["ASM"]= Array("iso2" => "AS", "name" => "AMERICAN SAMOA");
		$country["AND"]= Array("iso2" => "AD", "name" => "ANDORRA, PRINCIPALITY OF");
		$country["AGO"]= Array("iso2" => "AO", "name" => "ANGOLA, REPUBLIC OF");
		$country["AIA"]= Array("iso2" => "AI", "name" => "ANGUILLA");
		$country["ATA"]= Array("iso2" => "AQ", "name" => "ANTARCTICA (THE TERRITORY SOUT");
		$country["ATG"]= Array("iso2" => "AG", "name" => "ANTIGUA AND BARBUDA");
		$country["ARG"]= Array("iso2" => "AR", "name" => "ARGENTINA, ARGENTINE REPUBLIC");
		$country["ARM"]= Array("iso2" => "AM", "name" => "ARMENIA, REPUBLIC OF");
		$country["ABW"]= Array("iso2" => "AW", "name" => "ARUBA");
		$country["AUS"]= Array("iso2" => "AU", "name" => "AUSTRALIA, COMMONWEALTH OF");
		$country["AUT"]= Array("iso2" => "AT", "name" => "AUSTRIA, REPUBLIC OF");
		$country["AZE"]= Array("iso2" => "AZ", "name" => "AZERBAIJAN, REPUBLIC OF");
		$country["BHS"]= Array("iso2" => "BS", "name" => "BAHAMAS, COMMONWEALTH OF THE");
		$country["BHR"]= Array("iso2" => "BH", "name" => "BAHRAIN, KINGDOM OF");
		$country["BGD"]= Array("iso2" => "BD", "name" => "BANGLADESH, PEOPLE'S REPUBLIC");
		$country["BRB"]= Array("iso2" => "BB", "name" => "BARBADOS");
		$country["BLR"]= Array("iso2" => "BY", "name" => "BELARUS, REPUBLIC OF");
		$country["BEL"]= Array("iso2" => "BE", "name" => "BELGIUM, KINGDOM OF");
		$country["BLZ"]= Array("iso2" => "BZ", "name" => "BELIZE");
		$country["BEN"]= Array("iso2" => "BJ", "name" => "BENIN, REPUBLIC OF");
		$country["BMU"]= Array("iso2" => "BM", "name" => "BERMUDA");
		$country["BTN"]= Array("iso2" => "BT", "name" => "BHUTAN, KINGDOM OF");
		$country["BOL"]= Array("iso2" => "BO", "name" => "BOLIVIA, REPUBLIC OF");
		$country["BIH"]= Array("iso2" => "BA", "name" => "BOSNIA AND HERZEGOVINA");
		$country["BWA"]= Array("iso2" => "BW", "name" => "BOTSWANA, REPUBLIC OF");
		$country["BVT"]= Array("iso2" => "BV", "name" => "BOUVET ISLAND (BOUVETOYA)");
		$country["BRA"]= Array("iso2" => "BR", "name" => "BRAZIL, FEDERATIVE REPUBLIC OF");
		$country["IOT"]= Array("iso2" => "IO", "name" => "BRITISH INDIAN OCEAN TERRITORY");
		$country["VGB"]= Array("iso2" => "VG", "name" => "BRITISH VIRGIN ISLANDS");
		$country["BRN"]= Array("iso2" => "BN", "name" => "BRUNEI DARUSSALAM");
		$country["BGR"]= Array("iso2" => "BG", "name" => "BULGARIA, REPUBLIC OF");
		$country["BFA"]= Array("iso2" => "BF", "name" => "BURKINA FASO");
		$country["BDI"]= Array("iso2" => "BI", "name" => "BURUNDI, REPUBLIC OF");
		$country["KHM"]= Array("iso2" => "KH", "name" => "CAMBODIA, KINGDOM OF");
		$country["CMR"]= Array("iso2" => "CM", "name" => "CAMEROON, REPUBLIC OF");
		$country["CAN"]= Array("iso2" => "CA", "name" => "CANADA");
		$country["CPV"]= Array("iso2" => "CV", "name" => "CAPE VERDE, REPUBLIC OF");
		$country["CYM"]= Array("iso2" => "KY", "name" => "CAYMAN ISLANDS");
		$country["CAF"]= Array("iso2" => "CF", "name" => "CENTRAL AFRICAN REPUBLIC");
		$country["TCD"]= Array("iso2" => "TD", "name" => "CHAD, REPUBLIC OF");
		$country["CHL"]= Array("iso2" => "CL", "name" => "CHILE, REPUBLIC OF");
		$country["CHN"]= Array("iso2" => "CN", "name" => "CHINA, PEOPLE'S REPUBLIC OF");
		$country["TCH"]= Array("iso2" => "CS", "name" => "CZECH AND SLOVAK FEDERAL REPUBLIC");
		$country["CXR"]= Array("iso2" => "CX", "name" => "CHRISTMAS ISLAND");
		$country["CCK"]= Array("iso2" => "CC", "name" => "COCOS (KEELING) ISLANDS");
		$country["COL"]= Array("iso2" => "CO", "name" => "COLOMBIA, REPUBLIC OF");
		$country["COM"]= Array("iso2" => "KM", "name" => "COMOROS, UNION OF THE");
		$country["COD"]= Array("iso2" => "CD", "name" => "CONGO, DEMOCRATIC REPUBLIC OF");
		$country["COG"]= Array("iso2" => "CG", "name" => "CONGO, REPUBLIC OF THE");
		$country["COK"]= Array("iso2" => "CK", "name" => "COOK ISLANDS");
		$country["CRI"]= Array("iso2" => "CR", "name" => "COSTA RICA, REPUBLIC OF");
		$country["CIV"]= Array("iso2" => "CI", "name" => "COTE D'IVOIRE, REPUBLIC OF");
		$country["HRV"]= Array("iso2" => "HR", "name" => "CROATIA, REPUBLIC OF");
		$country["CUB"]= Array("iso2" => "CU", "name" => "CUBA, REPUBLIC OF");
		$country["CYP"]= Array("iso2" => "CY", "name" => "CYPRUS, REPUBLIC OF");
		$country["CZE"]= Array("iso2" => "CZ", "name" => "CZECH REPUBLIC");
		$country["DNK"]= Array("iso2" => "DK", "name" => "DENMARK, KINGDOM OF");
		$country["DJI"]= Array("iso2" => "DJ", "name" => "DJIBOUTI, REPUBLIC OF");
		$country["DMA"]= Array("iso2" => "DM", "name" => "DOMINICA, COMMONWEALTH OF");
		$country["DOM"]= Array("iso2" => "DO", "name" => "DOMINICAN REPUBLIC");
		$country["ECU"]= Array("iso2" => "EC", "name" => "ECUADOR, REPUBLIC OF");
		$country["EGY"]= Array("iso2" => "EG", "name" => "EGYPT, ARAB REPUBLIC OF");
		$country["SLV"]= Array("iso2" => "SV", "name" => "EL SALVADOR, REPUBLIC OF");
		$country["ENG"]= Array("iso2" => "GB", "name" => "ENGLAND");
		$country["GNQ"]= Array("iso2" => "GQ", "name" => "EQUATORIAL GUINEA, REPUBLIC OF");
		$country["ERI"]= Array("iso2" => "ER", "name" => "ERITREA, STATE OF");
		$country["EST"]= Array("iso2" => "EE", "name" => "ESTONIA, REPUBLIC OF");
		$country["ETH"]= Array("iso2" => "ET", "name" => "ETHIOPIA, FEDERAL DEMOCRATIC R");
		$country["EUR"]= Array("iso2" => "EU", "name" => "EUROPE");
		$country["FRO"]= Array("iso2" => "FO", "name" => "FAROE ISLANDS");
		$country["FLK"]= Array("iso2" => "FK", "name" => "FALKLAND ISLANDS (MALVINAS)");
		$country["FJI"]= Array("iso2" => "FJ", "name" => "FIJI, REPUBLIC OF THE FIJI ISL");
		$country["FIN"]= Array("iso2" => "FI", "name" => "FINLAND, REPUBLIC OF");
		$country["FRA"]= Array("iso2" => "FR", "name" => "FRANCE, FRENCH REPUBLIC");
		$country["GUF"]= Array("iso2" => "GF", "name" => "FRENCH GUIANA");
		$country["PYF"]= Array("iso2" => "PF", "name" => "FRENCH POLYNESIA");
		$country["ATF"]= Array("iso2" => "TF", "name" => "FRENCH SOUTHERN TERRITORIES");
		$country["GAB"]= Array("iso2" => "GA", "name" => "GABON, GABONESE REPUBLIC");
		$country["GMB"]= Array("iso2" => "GM", "name" => "GAMBIA, REPUBLIC OF THE");
		$country["GEO"]= Array("iso2" => "GE", "name" => "GEORGIA");
		$country["DEU"]= Array("iso2" => "DE", "name" => "GERMANY, FEDERAL REPUBLIC OF");
		$country["GHA"]= Array("iso2" => "GH", "name" => "GHANA, REPUBLIC OF");
		$country["GIB"]= Array("iso2" => "GI", "name" => "GIBRALTAR");
		$country["GRC"]= Array("iso2" => "GR", "name" => "GREECE, HELLENIC REPUBLIC");
		$country["GRL"]= Array("iso2" => "GL", "name" => "GREENLAND");
		$country["GRD"]= Array("iso2" => "GD", "name" => "GRENADA");
		$country["GLP"]= Array("iso2" => "GP", "name" => "GUADELOUPE");
		$country["GUM"]= Array("iso2" => "GU", "name" => "GUAM");
		$country["GTM"]= Array("iso2" => "GT", "name" => "GUATEMALA, REPUBLIC OF");
		$country["GGY"]= Array("iso2" => "GG", "name" => "GUERNSEY, BAILIWICK OF");
		$country["GIN"]= Array("iso2" => "GN", "name" => "GUINEA, REPUBLIC OF");
		$country["GNB"]= Array("iso2" => "GW", "name" => "GUINEA-BISSAU, REPUBLIC OF");
		$country["GUY"]= Array("iso2" => "GY", "name" => "GUYANA, CO-OPERATIVE REPUBLIC");
		$country["HTI"]= Array("iso2" => "HT", "name" => "HAITI, REPUBLIC OF");
		$country["HMD"]= Array("iso2" => "HM", "name" => "HEARD ISLAND AND MCDONALD ISLA");
		$country["VAT"]= Array("iso2" => "VA", "name" => "HOLY SEE (VATICAN CITY STATE)");
		$country["HND"]= Array("iso2" => "HN", "name" => "HONDURAS, REPUBLIC OF");
		$country["HKG"]= Array("iso2" => "HK", "name" => "HONG KONG, SPECIAL ADMINISTRAT");
		$country["HUN"]= Array("iso2" => "HU", "name" => "HUNGARY, REPUBLIC OF");
		$country["ISL"]= Array("iso2" => "IS", "name" => "ICELAND, REPUBLIC OF");
		$country["IND"]= Array("iso2" => "IN", "name" => "INDIA, REPUBLIC OF");
		$country["IDN"]= Array("iso2" => "ID", "name" => "INDONESIA, REPUBLIC OF");
		$country["IRN"]= Array("iso2" => "IR", "name" => "IRAN, ISLAMIC REPUBLIC OF");
		$country["IRQ"]= Array("iso2" => "IQ", "name" => "IRAQ, REPUBLIC OF");
		$country["IRL"]= Array("iso2" => "IE", "name" => "IRELAND");
		$country["IMN"]= Array("iso2" => "IM", "name" => "ISLE OF MAN");
		$country["ISR"]= Array("iso2" => "IL", "name" => "ISRAEL, STATE OF");
		$country["ITA"]= Array("iso2" => "IT", "name" => "ITALY, ITALIAN REPUBLIC");
		$country["JAM"]= Array("iso2" => "JM", "name" => "JAMAICA");
		$country["JPN"]= Array("iso2" => "JP", "name" => "JAPAN");
		$country["JEY"]= Array("iso2" => "JE", "name" => "JERSEY, BAILIWICK OF");
		$country["JOR"]= Array("iso2" => "JO", "name" => "JORDAN, HASHEMITE KINGDOM OF");
		$country["KAZ"]= Array("iso2" => "KZ", "name" => "KAZAKHSTAN, REPUBLIC OF");
		$country["KEN"]= Array("iso2" => "KE", "name" => "KENYA, REPUBLIC OF");
		$country["KIR"]= Array("iso2" => "KI", "name" => "KIRIBATI, REPUBLIC OF");
		$country["PRK"]= Array("iso2" => "KP", "name" => "KOREA, DEMOCRATIC PEOPLE'S REP");
		$country["KOR"]= Array("iso2" => "KR", "name" => "KOREA, REPUBLIC OF");
		$country["KWT"]= Array("iso2" => "KW", "name" => "KUWAIT, STATE OF");
		$country["KGZ"]= Array("iso2" => "KG", "name" => "KYRGYZ REPUBLIC");
		$country["LAO"]= Array("iso2" => "LA", "name" => "LAO PEOPLE'S DEMOCRATIC REPUBL");
		$country["LVA"]= Array("iso2" => "LV", "name" => "LATVIA, REPUBLIC OF");
		$country["LBN"]= Array("iso2" => "LB", "name" => "LEBANON, LEBANESE REPUBLIC");
		$country["LSO"]= Array("iso2" => "LS", "name" => "LESOTHO, KINGDOM OF");
		$country["LBR"]= Array("iso2" => "LR", "name" => "LIBERIA, REPUBLIC OF");
		$country["LBY"]= Array("iso2" => "LY", "name" => "LIBYAN ARAB JAMAHIRIYA");
		$country["LIE"]= Array("iso2" => "LI", "name" => "LIECHTENSTEIN, PRINCIPALITY OF");
		$country["LTU"]= Array("iso2" => "LT", "name" => "LITHUANIA, REPUBLIC OF");
		$country["LUX"]= Array("iso2" => "LU", "name" => "LUXEMBOURG, GRAND DUCHY OF");
		$country["MAC"]= Array("iso2" => "MO", "name" => "MACAO, SPECIAL ADMINISTRATIVE");
		$country["MKD"]= Array("iso2" => "MK", "name" => "MACEDONIA, THE FORMER YUGOSLAV");
		$country["MDG"]= Array("iso2" => "MG", "name" => "MADAGASCAR, REPUBLIC OF");
		$country["MWI"]= Array("iso2" => "MW", "name" => "MALAWI, REPUBLIC OF");
		$country["MYS"]= Array("iso2" => "MY", "name" => "MALAYSIA");
		$country["MDV"]= Array("iso2" => "MV", "name" => "MALDIVES, REPUBLIC OF");
		$country["MLI"]= Array("iso2" => "ML", "name" => "MALI, REPUBLIC OF");
		$country["MLT"]= Array("iso2" => "MT", "name" => "MALTA, REPUBLIC OF");
		$country["MHL"]= Array("iso2" => "MH", "name" => "MARSHALL ISLANDS, REPUBLIC OF");
		$country["MTQ"]= Array("iso2" => "MQ", "name" => "MARTINIQUE");
		$country["MRT"]= Array("iso2" => "MR", "name" => "MAURITANIA, ISLAMIC REPUBLIC O");
		$country["MUS"]= Array("iso2" => "MU", "name" => "MAURITIUS, REPUBLIC OF");
		$country["MYT"]= Array("iso2" => "YT", "name" => "MAYOTTE");
		$country["MEX"]= Array("iso2" => "MX", "name" => "MEXICO, UNITED MEXICAN STATES");
		$country["FSM"]= Array("iso2" => "FM", "name" => "MICRONESIA, FEDERATED STATES O");
		$country["MDA"]= Array("iso2" => "MD", "name" => "MOLDOVA, REPUBLIC OF");
		$country["MCO"]= Array("iso2" => "MC", "name" => "MONACO, PRINCIPALITY OF");
		$country["MNG"]= Array("iso2" => "MN", "name" => "MONGOLIA");
		$country["MNE"]= Array("iso2" => "ME", "name" => "MONTENEGRO, REPUBLIC OF");
		$country["MSR"]= Array("iso2" => "MS", "name" => "MONTSERRAT");
		$country["MAR"]= Array("iso2" => "MA", "name" => "MOROCCO, KINGDOM OF");
		$country["MOZ"]= Array("iso2" => "MZ", "name" => "MOZAMBIQUE, REPUBLIC OF");
		$country["MMR"]= Array("iso2" => "MM", "name" => "MYANMAR, UNION OF");
		$country["NAM"]= Array("iso2" => "NA", "name" => "NAMIBIA, REPUBLIC OF");
		$country["NRU"]= Array("iso2" => "NR", "name" => "NAURU, REPUBLIC OF");
		$country["NPL"]= Array("iso2" => "NP", "name" => "NEPAL, STATE OF");
		$country["ANT"]= Array("iso2" => "AN", "name" => "NETHERLANDS ANTILLES");
		$country["NLD"]= Array("iso2" => "NL", "name" => "NETHERLANDS, THE");
		$country["NCL"]= Array("iso2" => "NC", "name" => "NEW CALEDONIA");
		$country["NZL"]= Array("iso2" => "NZ", "name" => "NEW ZEALAND");
		$country["NIC"]= Array("iso2" => "NI", "name" => "NICARAGUA, REPUBLIC OF");
		$country["NER"]= Array("iso2" => "NE", "name" => "NIGER, REPUBLIC OF");
		$country["NGA"]= Array("iso2" => "NG", "name" => "NIGERIA, FEDERAL REPUBLIC OF");
		$country["NIU"]= Array("iso2" => "NU", "name" => "NIUE");
		$country["NFK"]= Array("iso2" => "NF", "name" => "NORFOLK ISLAND");
		$country["NIR"]= Array("iso2" => "NX", "name" => "NORTHERN IRELAND");
		$country["MNP"]= Array("iso2" => "MP", "name" => "NORTHERN MARIANA ISLANDS, COMM");
		$country["NOR"]= Array("iso2" => "NO", "name" => "NORWAY, KINGDOM OF");
		$country["OMN"]= Array("iso2" => "OM", "name" => "OMAN, SULTANATE OF");
		$country["PAK"]= Array("iso2" => "PK", "name" => "PAKISTAN, ISLAMIC REPUBLIC OF");
		$country["PLW"]= Array("iso2" => "PW", "name" => "PALAU, REPUBLIC OF");
		$country["PSE"]= Array("iso2" => "PS", "name" => "PALESTINIAN TERRITORY, OCCUPIE");
		$country["PAN"]= Array("iso2" => "PA", "name" => "PANAMA, REPUBLIC OF");
		$country["PNG"]= Array("iso2" => "PG", "name" => "PAPUA NEW GUINEA, INDEPENDENT");
		$country["PRY"]= Array("iso2" => "PY", "name" => "PARAGUAY, REPUBLIC OF");
		$country["PER"]= Array("iso2" => "PE", "name" => "PERU, REPUBLIC OF");
		$country["PHL"]= Array("iso2" => "PH", "name" => "PHILIPPINES, REPUBLIC OF THE");
		$country["PCN"]= Array("iso2" => "PN", "name" => "PITCAIRN ISLANDS");
		$country["POL"]= Array("iso2" => "PL", "name" => "POLAND, REPUBLIC OF");
		$country["PRT"]= Array("iso2" => "PT", "name" => "PORTUGAL, PORTUGUESE REPUBLIC");
		$country["PRI"]= Array("iso2" => "PR", "name" => "PUERTO RICO, COMMONWEALTH OF");
		$country["QAT"]= Array("iso2" => "QA", "name" => "QATAR, STATE OF");
		$country["REU"]= Array("iso2" => "RE", "name" => "REUNION");
		$country["ROU"]= Array("iso2" => "RO", "name" => "ROMANIA");
		$country["RUS"]= Array("iso2" => "RU", "name" => "RUSSIAN FEDERATION");
		$country["RWA"]= Array("iso2" => "RW", "name" => "RWANDA, REPUBLIC OF");
		$country["BLM"]= Array("iso2" => "BL", "name" => "SAINT BARTHELEMY");
		$country["SHN"]= Array("iso2" => "SH", "name" => "SAINT HELENA");
		$country["KNA"]= Array("iso2" => "KN", "name" => "SAINT KITTS AND NEVIS, FEDERAT");
		$country["LCA"]= Array("iso2" => "LC", "name" => "SAINT LUCIA");
		$country["MAF"]= Array("iso2" => "MF", "name" => "SAINT MARTIN");
		$country["SPM"]= Array("iso2" => "PM", "name" => "SAINT PIERRE AND MIQUELON");
		$country["VCT"]= Array("iso2" => "VC", "name" => "SAINT VINCENT AND THE GRENADIN");
		$country["WSM"]= Array("iso2" => "WS", "name" => "SAMOA, INDEPENDENT STATE OF");
		$country["SMR"]= Array("iso2" => "SM", "name" => "SAN MARINO, REPUBLIC OF");
		$country["STP"]= Array("iso2" => "ST", "name" => "SAO TOME AND PRINCIPE, DEMOCRA");
		$country["SAU"]= Array("iso2" => "SA", "name" => "SAUDI ARABIA, KINGDOM OF");
		$country["SCO"]= Array("iso2" => "KS", "name" => "SCOTLAND");
		$country["SEN"]= Array("iso2" => "SN", "name" => "SENEGAL, REPUBLIC OF");
		$country["SRB"]= Array("iso2" => "RS", "name" => "SERBIA, REPUBLIC OF");
		$country["SYC"]= Array("iso2" => "SC", "name" => "SEYCHELLES, REPUBLIC OF");
		$country["SLE"]= Array("iso2" => "SL", "name" => "SIERRA LEONE, REPUBLIC OF");
		$country["SGP"]= Array("iso2" => "SG", "name" => "SINGAPORE, REPUBLIC OF");
		$country["SVK"]= Array("iso2" => "SK", "name" => "SLOVAKIA (SLOVAK REPUBLIC)");
		$country["SVN"]= Array("iso2" => "SI", "name" => "SLOVENIA, REPUBLIC OF");
		$country["SLB"]= Array("iso2" => "SB", "name" => "SOLOMON ISLANDS");
		$country["SOM"]= Array("iso2" => "SO", "name" => "SOMALIA, SOMALI REPUBLIC");
		$country["ZAF"]= Array("iso2" => "ZA", "name" => "SOUTH AFRICA, REPUBLIC OF");
		$country["SGS"]= Array("iso2" => "GS", "name" => "SOUTH GEORGIA AND THE SOUTH SA");
		$country["ESP"]= Array("iso2" => "ES", "name" => "SPAIN, KINGDOM OF");
		$country["LKA"]= Array("iso2" => "LK", "name" => "SRI LANKA, DEMOCRATIC SOCIALIS");
		$country["SDN"]= Array("iso2" => "SD", "name" => "SUDAN, REPUBLIC OF");
		$country["SUR"]= Array("iso2" => "SR", "name" => "SURINAME, REPUBLIC OF");
		$country["SJM"]= Array("iso2" => "SJ", "name" => "SVALBARD & JAN MAYEN ISLANDS");
		$country["SWZ"]= Array("iso2" => "SZ", "name" => "SWAZILAND, KINGDOM OF");
		$country["SWE"]= Array("iso2" => "SE", "name" => "SWEDEN, KINGDOM OF");
		$country["CHE"]= Array("iso2" => "CH", "name" => "SWITZERLAND, SWISS CONFEDERATI");
		$country["SYR"]= Array("iso2" => "SY", "name" => "SYRIAN ARAB REPUBLIC");
		$country["TWN"]= Array("iso2" => "TW", "name" => "TAIWAN");
		$country["TJK"]= Array("iso2" => "TJ", "name" => "TAJIKISTAN, REPUBLIC OF");
		$country["TZA"]= Array("iso2" => "TZ", "name" => "TANZANIA, UNITED REPUBLIC OF");
		$country["THA"]= Array("iso2" => "TH", "name" => "THAILAND, KINGDOM OF");
		$country["TLS"]= Array("iso2" => "TL", "name" => "TIMOR-LESTE, DEMOCRATIC REPUBL");
		$country["TGO"]= Array("iso2" => "TG", "name" => "TOGO, TOGOLESE REPUBLIC");
		$country["TKL"]= Array("iso2" => "TK", "name" => "TOKELAU");
		$country["TON"]= Array("iso2" => "TO", "name" => "TONGA, KINGDOM OF");
		$country["TTO"]= Array("iso2" => "TT", "name" => "TRINIDAD AND TOBAGO, REPUBLIC");
		$country["TUN"]= Array("iso2" => "TN", "name" => "TUNISIA, TUNISIAN REPUBLIC");
		$country["TUR"]= Array("iso2" => "TR", "name" => "TURKEY, REPUBLIC OF");
		$country["TKM"]= Array("iso2" => "TM", "name" => "TURKMENISTAN");
		$country["TCA"]= Array("iso2" => "TC", "name" => "TURKS AND CAICOS ISLANDS");
		$country["TUV"]= Array("iso2" => "TV", "name" => "TUVALU");
		$country["UGA"]= Array("iso2" => "UG", "name" => "UGANDA, REPUBLIC OF");
		$country["UKR"]= Array("iso2" => "UA", "name" => "UKRAINE");
		$country["ARE"]= Array("iso2" => "AE", "name" => "UNITED ARAB EMIRATES");
		$country["GBR"]= Array("iso2" => "GB", "name" => "UNITED KINGDOM OF GREAT BRITAIN");
		$country["USA"]= Array("iso2" => "US", "name" => "UNITED STATES OF AMERICA");
		$country["UMI"]= Array("iso2" => "UM", "name" => "UNITED STATES MINOR OUTLYING I");
		$country["VIR"]= Array("iso2" => "VI", "name" => "UNITED STATES VIRGIN ISLANDS");
		$country["URY"]= Array("iso2" => "UY", "name" => "URUGUAY, EASTERN REPUBLIC OF");
		$country["UZB"]= Array("iso2" => "UZ", "name" => "UZBEKISTAN, REPUBLIC OF");
		$country["VUT"]= Array("iso2" => "VU", "name" => "VANUATU, REPUBLIC OF");
		$country["VEN"]= Array("iso2" => "VE", "name" => "VENEZUELA, BOLIVARIAN REPUBLIC");
		$country["VNM"]= Array("iso2" => "VN", "name" => "VIETNAM, SOCIALIST REPUBLIC OF");
		$country["WAL"]= Array("iso2" => "WA", "name" => "WALES");
		$country["WLF"]= Array("iso2" => "WF", "name" => "WALLIS AND FUTUNA");
		$country["ESH"]= Array("iso2" => "EH", "name" => "WESTERN SAHARA");
		$country["YEM"]= Array("iso2" => "YE", "name" => "YEMEN");
		$country["YUG"]= Array("iso2" => "YU", "name" => "YUGOSLAVIA, SOCIALIST FEDERAL REPUBLIC OF");
		$country["ZMB"]= Array("iso2" => "ZM", "name" => "ZAMBIA, REPUBLIC OF");
		$country["ZWE"]= Array("iso2" => "ZW", "name" => "ZIMBABWE, REPUBLIC OF");

    $country["URS"]= Array("iso2" => "SU", "name" => "UDSSR");
    
		$country["999"]= Array("iso2" => "99", "name" => "DDR");
		$country["222"]= Array("iso2" => "22", "name" => "FIFA");
		$country["333"]= Array("iso2" => "33", "name" => "AFC");
		$country["444"]= Array("iso2" => "44", "name" => "CAF");
		$country["555"]= Array("iso2" => "55", "name" => "CONCACAF");
		$country["666"]= Array("iso2" => "66", "name" => "CONMEBAL");
		$country["777"]= Array("iso2" => "77", "name" => "OFC");
		$country["888"]= Array("iso2" => "88", "name" => "UEFA");

		$country["0"]= Array("iso2" => "0", "name" => "NO VALID COUNTRY");
    	return $country;
	}

	function getCountryOptions($value_tag='value', $text_tag='text')
	{
		$countries=Countries::getCountries();
		$options=array();
		foreach ($countries AS $k => $c)
		{
			$options[]=JHTML::_('select.option',$k,JText::_($c['name']),$value_tag,$text_tag);
		}

/*
sortfunction for countrynames
diddipoeler
*/
$options=Countries::sortStdArray($options,"text");

		return $options;
	}

	function convertIso2to3($iso_code_2)
	{
		$convert2to3["AF"]="AFG";
		$convert2to3["AX"]="ALA";
		$convert2to3["AL"]="ALB";
		$convert2to3["DZ"]="DZA";
		$convert2to3["AS"]="ASM";
		$convert2to3["AD"]="AND";
		$convert2to3["AO"]="AGO";
		$convert2to3["AI"]="AIA";
		$convert2to3["AQ"]="ATA";
		$convert2to3["AG"]="ATG";
		$convert2to3["AR"]="ARG";
		$convert2to3["AM"]="ARM";
		$convert2to3["AW"]="ABW";
		$convert2to3["AU"]="AUS";
		$convert2to3["AT"]="AUT";
		$convert2to3["AZ"]="AZE";
		$convert2to3["BS"]="BHS";
		$convert2to3["BH"]="BHR";
		$convert2to3["BD"]="BGD";
		$convert2to3["BB"]="BRB";
		$convert2to3["BY"]="BLR";
		$convert2to3["BE"]="BEL";
		$convert2to3["BZ"]="BLZ";
		$convert2to3["BJ"]="BEN";
		$convert2to3["BM"]="BMU";
		$convert2to3["BT"]="BTN";
		$convert2to3["BO"]="BOL";
		$convert2to3["BA"]="BIH";
		$convert2to3["BW"]="BWA";
		$convert2to3["BV"]="BVT";
		$convert2to3["BR"]="BRA";
		$convert2to3["IO"]="IOT";
		$convert2to3["BN"]="BRN";
		$convert2to3["BG"]="BGR";
		$convert2to3["BF"]="BFA";
		$convert2to3["BI"]="BDI";
		$convert2to3["KH"]="KHM";
		$convert2to3["CM"]="CMR";
		$convert2to3["CA"]="CAN";
		$convert2to3["CV"]="CPV";
		$convert2to3["KY"]="CYM";
		$convert2to3["CF"]="CAF";
		$convert2to3["TD"]="TCD";
		$convert2to3["CL"]="CHL";
		$convert2to3["CN"]="CHN";
		$convert2to3["CS"]="TCH";
		$convert2to3["CX"]="CXR";
		$convert2to3["CC"]="CCK";
		$convert2to3["CO"]="COL";
		$convert2to3["KM"]="COM";
		$convert2to3["CG"]="COG";
		$convert2to3["CD"]="COD";
		$convert2to3["CK"]="COK";
		$convert2to3["CR"]="CRI";
		$convert2to3["CI"]="CIV";
		$convert2to3["HR"]="HRV";
		$convert2to3["CU"]="CUB";
		$convert2to3["CY"]="CYP";
		$convert2to3["CZ"]="CZE";
		$convert2to3["DK"]="DNK";
		$convert2to3["DJ"]="DJI";
		$convert2to3["DM"]="DMA";
		$convert2to3["DO"]="DOM";
		$convert2to3["EC"]="ECU";
		$convert2to3["EG"]="EGY";
		$convert2to3["EU"]="EUR";
		$convert2to3["SV"]="SLV";
		$convert2to3["GQ"]="GNQ";
		$convert2to3["ER"]="ERI";
		$convert2to3["EE"]="EST";
		$convert2to3["ET"]="ETH";
		$convert2to3["FK"]="FLK";
		$convert2to3["FO"]="FRO";
		$convert2to3["FJ"]="FJI";
		$convert2to3["FI"]="FIN";
		$convert2to3["FR"]="FRA";
		$convert2to3["GF"]="GUF";
		$convert2to3["PF"]="PYF";
		$convert2to3["TF"]="ATF";
		$convert2to3["GA"]="GAB";
		$convert2to3["GM"]="GMB";
		$convert2to3["GE"]="GEO";
		$convert2to3["DE"]="DEU";
		$convert2to3["GH"]="GHA";
		$convert2to3["GI"]="GIB";
		$convert2to3["GR"]="GRC";
		$convert2to3["GL"]="GRL";
		$convert2to3["GD"]="GRD";
		$convert2to3["GP"]="GLP";
		$convert2to3["GU"]="GUM";
		$convert2to3["GT"]="GTM";
		$convert2to3["GG"]="GGY";
		$convert2to3["GN"]="GIN";
		$convert2to3["GW"]="GNB";
		$convert2to3["GY"]="GUY";
		$convert2to3["HT"]="HTI";
		$convert2to3["HM"]="HMD";
		$convert2to3["VA"]="VAT";
		$convert2to3["HN"]="HND";
		$convert2to3["HK"]="HKG";
		$convert2to3["HU"]="HUN";
		$convert2to3["IS"]="ISL";
		$convert2to3["IN"]="IND";
		$convert2to3["ID"]="IDN";
		$convert2to3["IR"]="IRN";
		$convert2to3["IQ"]="IRQ";
		$convert2to3["IE"]="IRL";
		$convert2to3["IM"]="IMM";
		$convert2to3["IL"]="ISR";
		$convert2to3["IT"]="ITA";
		$convert2to3["JM"]="JAM";
		$convert2to3["JP"]="JPN";
		$convert2to3["JE"]="JEY";
		$convert2to3["JO"]="JOR";
		$convert2to3["KZ"]="KAZ";
		$convert2to3["KE"]="KEN";
		$convert2to3["KI"]="KIR";
		$convert2to3["KP"]="PRK";
		$convert2to3["KR"]="KOR";
		$convert2to3["KW"]="KWT";
		$convert2to3["KG"]="KGZ";
		$convert2to3["LA"]="LAO";
		$convert2to3["LV"]="LVA";
		$convert2to3["LB"]="LBN";
		$convert2to3["LS"]="LSO";
		$convert2to3["LR"]="LBR";
		$convert2to3["LY"]="LBY";
		$convert2to3["LI"]="LIE";
		$convert2to3["LT"]="LTU";
		$convert2to3["LU"]="LUX";
		$convert2to3["MO"]="MAC";
		$convert2to3["MK"]="MKD";
		$convert2to3["MG"]="MDG";
		$convert2to3["MW"]="MWI";
		$convert2to3["MY"]="MYS";
		$convert2to3["MV"]="MDV";
		$convert2to3["ML"]="MLI";
		$convert2to3["MT"]="MLT";
		$convert2to3["MH"]="MHL";
		$convert2to3["MQ"]="MTQ";
		$convert2to3["MR"]="MRT";
		$convert2to3["MU"]="MUS";
		$convert2to3["YT"]="MYT";
		$convert2to3["MX"]="MEX";
		$convert2to3["FM"]="FSM";
		$convert2to3["MD"]="MDA";
		$convert2to3["MC"]="MCO";
		$convert2to3["MN"]="MNG";
		$convert2to3["ME"]="MNE";
		$convert2to3["MS"]="MSR";
		$convert2to3["MA"]="MAR";
		$convert2to3["MZ"]="MOZ";
		$convert2to3["MM"]="MMR";
		$convert2to3["NA"]="NAM";
		$convert2to3["NR"]="NRU";
		$convert2to3["NP"]="NPL";
		$convert2to3["NL"]="NLD";
		$convert2to3["AN"]="ANT";
		$convert2to3["NC"]="NCL";
		$convert2to3["NZ"]="NZL";
		$convert2to3["NI"]="NIC";
		$convert2to3["NE"]="NER";
		$convert2to3["NG"]="NGA";
		$convert2to3["NU"]="NIU";
		$convert2to3["NF"]="NFK";
		$convert2to3["NX"]="NIR";
		$convert2to3["MP"]="MNP";
		$convert2to3["NO"]="NOR";
		$convert2to3["OM"]="OMN";
		$convert2to3["PK"]="PAK";
		$convert2to3["PW"]="PLW";
		$convert2to3["PS"]="PSE";
		$convert2to3["PA"]="PAN";
		$convert2to3["PG"]="PNG";
		$convert2to3["PY"]="PRY";
		$convert2to3["PE"]="PER";
		$convert2to3["PH"]="PHL";
		$convert2to3["PN"]="PCN";
		$convert2to3["PL"]="POL";
		$convert2to3["PT"]="PRT";
		$convert2to3["PR"]="PRI";
		$convert2to3["QA"]="QAT";
		$convert2to3["RE"]="REU";
		$convert2to3["RO"]="ROU";
		$convert2to3["RU"]="RUS";
		$convert2to3["RW"]="RWA";
		$convert2to3["BL"]="BLM";
		$convert2to3["SH"]="SHN";
		$convert2to3["KN"]="KNA";
		$convert2to3["LC"]="LCA";
		$convert2to3["MT"]="MAF";
		$convert2to3["PM"]="SPM";
		$convert2to3["VC"]="VCT";
		$convert2to3["WS"]="WSM";
		$convert2to3["SM"]="SMR";
		$convert2to3["ST"]="STP";
		$convert2to3["SA"]="SAU";
		$convert2to3["KS"]="SCO";
		$convert2to3["SN"]="SEN";
		$convert2to3["RS"]="SRB";
		$convert2to3["SC"]="SYC";
		$convert2to3["SL"]="SLE";
		$convert2to3["SG"]="SGP";
		$convert2to3["SK"]="SVK";
		$convert2to3["SI"]="SVN";
		$convert2to3["SB"]="SLB";
		$convert2to3["SO"]="SOM";
		$convert2to3["ZA"]="ZAF";
		$convert2to3["GS"]="SGS";
		$convert2to3["ES"]="ESP";
		$convert2to3["LK"]="LKA";
		$convert2to3["SD"]="SDN";
		$convert2to3["SR"]="SUR";
		$convert2to3["SJ"]="SJM";
		$convert2to3["SZ"]="SWZ";
		$convert2to3["SE"]="SWE";
		$convert2to3["CH"]="CHE";
		$convert2to3["SY"]="SYR";
		$convert2to3["TW"]="TWN";
		$convert2to3["TJ"]="TJK";
		$convert2to3["TZ"]="TZA";
		$convert2to3["TH"]="THA";
		$convert2to3["TL"]="TLS";
		$convert2to3["TG"]="TGO";
		$convert2to3["TK"]="TKL";
		$convert2to3["TO"]="TON";
		$convert2to3["TT"]="TTO";
		$convert2to3["TN"]="TUN";
		$convert2to3["TR"]="TUR";
		$convert2to3["TM"]="TKM";
		$convert2to3["TC"]="TCA";
		$convert2to3["TV"]="TUV";
		$convert2to3["UG"]="UGA";
		$convert2to3["UA"]="UKR";
		$convert2to3["AE"]="ARE";
		$convert2to3["GB"]="GBR";
		$convert2to3["US"]="USA";
		$convert2to3["UM"]="UMI";
		$convert2to3["UY"]="URY";
		$convert2to3["UZ"]="UZB";
		$convert2to3["VU"]="VUT";
		$convert2to3["VA"]="VAT";
		$convert2to3["VE"]="VEN";
		$convert2to3["VN"]="VNM";
		$convert2to3["WA"]="WAL";
		$convert2to3["VG"]="VGB";
		$convert2to3["VI"]="VIR";
		$convert2to3["WF"]="WLF";
		$convert2to3["EH"]="ESH";
		$convert2to3["YE"]="YEM";
		$convert2to3["YU"]="YUG";
		$convert2to3["ZM"]="ZMB";
		$convert2to3["ZW"]="ZWE";
		
		$convert2to3["SU"]="URS";

		$convert2to3["99"]="999";
		
		$convert2to3["33"]="333";
		$convert2to3["22"]="222";
		$convert2to3["44"]="444";
		$convert2to3["55"]="555";
		$convert2to3["66"]="666";
		$convert2to3["77"]="777";
		$convert2to3["88"]="888";

		if (isset($convert2to3[$iso_code_2]))
		{
			return $convert2to3[$iso_code_2];
		}
		return null;
	}

	function getCountryInfo($country)
	{
	$countryinfo = array();
	
	$fifacountry = JText::_( Countriesdiddipoeler::convertIso3toFIFA($country));
	if ( $fifacountry )
{
$country = $fifacountry;
}
	
	$derlink = 'http://de.fifa.com/associations/association='.$country.'/index.html';
// echo 'der link '.$derlink.'<br>';

$ch = curl_init ();
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_URL, $derlink);
curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
$resulttab = curl_exec ($ch);
curl_close ($ch); 

// $resulttab = file_get_contents($derlink);

//$pattern = '!<div class="maInfo">(.*?)</div>!isS';
$pattern = '!<table class="maData"(.*?)>(.*?)</table>!isS';

// RegEx mit preg_match_all() auswerten
preg_match_all($pattern, $resulttab, $seitennav, PREG_SET_ORDER);

// echo 'getCountryInfo<br>';
// echo '<pre>', print_r($seitennav), '</pre><br>';
$countryinfo[0] = $seitennav[0][0];

$pattern = '!<table class="maTable"(.*?)>(.*?)</table>!isS';

// RegEx mit preg_match_all() auswerten
preg_match_all($pattern, $resulttab, $seitennav, PREG_SET_ORDER);
$countryinfo[1] = $seitennav[0][0];

return $countryinfo;
  }
  
  function convertIso3toFIFA($iso_code_3)
	{
	  $convert3toFIFA["DEU"]="GER";
    $convert3toFIFA["OMN"]="OMA";
	  $convert3toFIFA["TGO"]="TOG";
	  $convert3toFIFA["GMB"]="GAM";
	  $convert3toFIFA["TZA"]="TAN";
	  $convert3toFIFA["VUT"]="VAN";
	  $convert3toFIFA["GRC"]="GRE";
	  $convert3toFIFA["ZAF"]="RSA";
	  $convert3toFIFA["CHE"]="SUI";
	  $convert3toFIFA["NLD"]="NED";
	  $convert3toFIFA["CRI"]="CRC";
	  $convert3toFIFA["GTM"]="GUA";
	  $convert3toFIFA["HND"]="HON";
	  $convert3toFIFA["KWT"]="KUW";
	  $convert3toFIFA["MYS"]="MAS";
	  $convert3toFIFA["SAU"]="KSA";
	  $convert3toFIFA["SGP"]="SIN";
	  $convert3toFIFA["PYF"]="TAH";
	  $convert3toFIFA["ZMB"]="ZAM";
	  $convert3toFIFA["ZWE"]="ZIM";
	  $convert3toFIFA["ABW"]="ARU";
	  $convert3toFIFA["BHS"]="BAH";
	  $convert3toFIFA["BMU"]="BER";
	  $convert3toFIFA["GRD"]="GRN";
	  $convert3toFIFA["NIC"]="NCA";
	  $convert3toFIFA["PRI"]="PUR";              
	  $convert3toFIFA["TTO"]="TRI";
	  $convert3toFIFA["LBN"]="LIB";
	  $convert3toFIFA["FJI"]="FIJ";
	  $convert3toFIFA["ASM"]="ASA";
	  $convert3toFIFA["SLB"]="SOL";
	  $convert3toFIFA["CHL"]="CHI";
	  $convert3toFIFA["DNK"]="DEN";
	  $convert3toFIFA["DZA"]="ALG";
	  $convert3toFIFA["AGO"]="ANG";
	  $convert3toFIFA["BGR"]="BUL";
	  $convert3toFIFA["SDN"]="SUD";
	  $convert3toFIFA["ARE"]="UAE";
	  $convert3toFIFA["URY"]="URU";
	  $convert3toFIFA["PRY"]="PAR";
	  $convert3toFIFA["LSO"]="LES";
	  $convert3toFIFA["MUS"]="MRI";      
	  $convert3toFIFA["MMR"]="MYA";
	  $convert3toFIFA["KHM"]="CAM";
	  
	  if (isset($convert3toFIFA[$iso_code_3]))
		{
			return $convert3toFIFA[$iso_code_3];
		}
		return null;
		
	}
  
  function convertIso3to2($iso_code_3)
	{
		$convert3to2["AFG"]="AF";
		$convert3to2["ALA"]="AX";
		$convert3to2["ALB"]="AL";
		$convert3to2["DZA"]="DZ";
		$convert3to2["ASM"]="AS";
		$convert3to2["AND"]="AD";
		$convert3to2["AGO"]="AO";
		$convert3to2["AIA"]="AI";
		$convert3to2["ATA"]="AQ";
		$convert3to2["ATG"]="AG";
		$convert3to2["ARG"]="AR";
		$convert3to2["ARM"]="AM";
		$convert3to2["ABW"]="AW";
		$convert3to2["AUS"]="AU";
		$convert3to2["AUT"]="AT";
		$convert3to2["AZE"]="AZ";
		$convert3to2["BHS"]="BS";
		$convert3to2["BHR"]="BH";
		$convert3to2["BGD"]="BD";
		$convert3to2["BRB"]="BB";
		$convert3to2["BLR"]="BY";
		$convert3to2["BEL"]="BE";
		$convert3to2["BLZ"]="BZ";
		$convert3to2["BEN"]="BJ";
		$convert3to2["BMU"]="BM";
		$convert3to2["BTN"]="BT";
		$convert3to2["BOL"]="BO";
		$convert3to2["BIH"]="BA";
		$convert3to2["BWA"]="BW";
		$convert3to2["BVT"]="BV";
		$convert3to2["BRA"]="BR";
		$convert3to2["IOT"]="IO";
		$convert3to2["BRN"]="BN";
		$convert3to2["BGR"]="BG";
		$convert3to2["BFA"]="BF";
		$convert3to2["BDI"]="BI";
		$convert3to2["KHM"]="KH";
		$convert3to2["CMR"]="CM";
		$convert3to2["CAN"]="CA";
		$convert3to2["CPV"]="CV";
		$convert3to2["CYM"]="KY";
		$convert3to2["CAF"]="CF";
		$convert3to2["TCD"]="TD";
		$convert3to2["CHL"]="CL";
		$convert3to2["CHN"]="CN";
		$convert3to2["TCH"]="CS";
		$convert3to2["CXR"]="CX";
		$convert3to2["CCK"]="CC";
		$convert3to2["COL"]="CO";
		$convert3to2["COM"]="KM";
		$convert3to2["COG"]="CG";
		$convert3to2["COD"]="CD";
		$convert3to2["COK"]="CK";
		$convert3to2["CRI"]="CR";
		$convert3to2["CIV"]="CI";
		$convert3to2["HRV"]="HR";
		$convert3to2["CUB"]="CU";
		$convert3to2["CYP"]="CY";
		$convert3to2["CZE"]="CZ";
		$convert3to2["DNK"]="DK";
		$convert3to2["DJI"]="DJ";
		$convert3to2["DMA"]="DM";
		$convert3to2["DOM"]="DO";
		$convert3to2["ECU"]="EC";
		$convert3to2["EGY"]="EG";
		$convert3to2["EUR"]="EU";
		$convert3to2["SLV"]="SV";
		$convert3to2["GNQ"]="GQ";
		$convert3to2["ERI"]="ER";
		$convert3to2["EST"]="EE";
		$convert3to2["ETH"]="ET";
		$convert3to2["FLK"]="FK";
		$convert3to2["FRO"]="FO";
		$convert3to2["FJI"]="FJ";
		$convert3to2["FIN"]="FI";
		$convert3to2["FRA"]="FR";
		$convert3to2["GUF"]="GF";
		$convert3to2["PYF"]="PF";
		$convert3to2["ATF"]="TF";
		$convert3to2["GAB"]="GA";
		$convert3to2["GMB"]="GM";
		$convert3to2["GEO"]="GE";
		$convert3to2["DEU"]="DE";
		$convert3to2["GHA"]="GH";
		$convert3to2["GIB"]="GI";
		$convert3to2["GRC"]="GR";
		$convert3to2["GRL"]="GL";
		$convert3to2["GRD"]="GD";
		$convert3to2["GLP"]="GP";
		$convert3to2["GUM"]="GU";
		$convert3to2["GTM"]="GT";
		$convert3to2["GGY"]="GG";
		$convert3to2["GIN"]="GN";
		$convert3to2["GNB"]="GW";
		$convert3to2["GUY"]="GY";
		$convert3to2["HTI"]="HT";
		$convert3to2["HMD"]="HM";
		$convert3to2["VAT"]="VA";
		$convert3to2["HND"]="HN";
		$convert3to2["HKG"]="HK";
		$convert3to2["HUN"]="HU";
		$convert3to2["ISL"]="IS";
		$convert3to2["IND"]="IN";
		$convert3to2["IDN"]="ID";
		$convert3to2["IRN"]="IR";
		$convert3to2["IRQ"]="IQ";
		$convert3to2["IRL"]="IE";
		$convert3to2["IMM"]="IM";
		$convert3to2["ISR"]="IL";
		$convert3to2["ITA"]="IT";
		$convert3to2["JAM"]="JM";
		$convert3to2["JPN"]="JP";
		$convert3to2["JEY"]="JE";
		$convert3to2["JOR"]="JO";
		$convert3to2["KAZ"]="KZ";
		$convert3to2["KEN"]="KE";
		$convert3to2["KIR"]="KI";
		$convert3to2["PRK"]="KP";
		$convert3to2["KOR"]="KR";
		$convert3to2["KWT"]="KW";
		$convert3to2["KGZ"]="KG";
		$convert3to2["LAO"]="LA";
		$convert3to2["LVA"]="LV";
		$convert3to2["LBN"]="LB";
		$convert3to2["LSO"]="LS";
		$convert3to2["LBR"]="LR";
		$convert3to2["LBY"]="LY";
		$convert3to2["LIE"]="LI";
		$convert3to2["LTU"]="LT";
		$convert3to2["LUX"]="LU";
		$convert3to2["MAC"]="MO";
		$convert3to2["MKD"]="MK";
		$convert3to2["MDG"]="MG";
		$convert3to2["MWI"]="MW";
		$convert3to2["MYS"]="MY";
		$convert3to2["MDV"]="MV";
		$convert3to2["MLI"]="ML";
		$convert3to2["MLT"]="MT";
		$convert3to2["MHL"]="MH";
		$convert3to2["MTQ"]="MQ";
		$convert3to2["MRT"]="MR";
		$convert3to2["MUS"]="MU";
		$convert3to2["MYT"]="YT";
		$convert3to2["MEX"]="MX";
		$convert3to2["FSM"]="FM";
		$convert3to2["MDA"]="MD";
		$convert3to2["MCO"]="MC";
		$convert3to2["MNG"]="MN";
		$convert3to2["MNE"]="ME";
		$convert3to2["MSR"]="MS";
		$convert3to2["MAR"]="MA";
		$convert3to2["MOZ"]="MZ";
		$convert3to2["MMR"]="MM";
		$convert3to2["NAM"]="NA";
		$convert3to2["NRU"]="NR";
		$convert3to2["NPL"]="NP";
		$convert3to2["NLD"]="NL";
		$convert3to2["ANT"]="AN";
		$convert3to2["NCL"]="NC";
		$convert3to2["NZL"]="NZ";
		$convert3to2["NIC"]="NI";
		$convert3to2["NER"]="NE";
		$convert3to2["NGA"]="NG";
		$convert3to2["NIU"]="NU";
		$convert3to2["NFK"]="NF";
		$convert3to2["NIR"]="NX";
		$convert3to2["MNP"]="MP";
		$convert3to2["NOR"]="NO";
		$convert3to2["OMN"]="OM";
		$convert3to2["PAK"]="PK";
		$convert3to2["PLW"]="PW";
		$convert3to2["PSE"]="PS";
		$convert3to2["PAN"]="PA";
		$convert3to2["PNG"]="PG";
		$convert3to2["PRY"]="PY";
		$convert3to2["PER"]="PE";
		$convert3to2["PHL"]="PH";
		$convert3to2["PCN"]="PN";
		$convert3to2["POL"]="PL";
		$convert3to2["PRT"]="PT";
		$convert3to2["PRI"]="PR";
		$convert3to2["QAT"]="QA";
		$convert3to2["REU"]="RE";
		$convert3to2["ROU"]="RO";
		$convert3to2["RUS"]="RU";
		$convert3to2["RWA"]="RW";
		$convert3to2["BLM"]="BL";
		$convert3to2["SHN"]="SH";
		$convert3to2["KNA"]="KN";
		$convert3to2["LCA"]="LC";
		$convert3to2["MAF"]="MT";
		$convert3to2["SPM"]="PM";
		$convert3to2["VCT"]="VC";
		$convert3to2["WSM"]="WS";
		$convert3to2["SMR"]="SM";
		$convert3to2["STP"]="ST";
		$convert3to2["SAU"]="SA";
		$convert3to2["SCO"]="KS";
		$convert3to2["SEN"]="SN";
		$convert3to2["SRB"]="RS";
		$convert3to2["SYC"]="SC";
		$convert3to2["SLE"]="SL";
		$convert3to2["SGP"]="SG";
		$convert3to2["SVK"]="SK";
		$convert3to2["SVN"]="SI";
		$convert3to2["SLB"]="SB";
		$convert3to2["SOM"]="SO";
		$convert3to2["ZAF"]="ZA";
		$convert3to2["SGS"]="GS";
		$convert3to2["ESP"]="ES";
		$convert3to2["LKA"]="LK";
		$convert3to2["SDN"]="SD";
		$convert3to2["SUR"]="SR";
		$convert3to2["SJM"]="SJ";
		$convert3to2["SWZ"]="SZ";
		$convert3to2["SWE"]="SE";
		$convert3to2["CHE"]="CH";
		$convert3to2["SYR"]="SY";
		$convert3to2["TWN"]="TW";
		$convert3to2["TJK"]="TJ";
		$convert3to2["TZA"]="TZ";
		$convert3to2["THA"]="TH";
		$convert3to2["TLS"]="TL";
		$convert3to2["TGO"]="TG";
		$convert3to2["TKL"]="TK";
		$convert3to2["TON"]="TO";
		$convert3to2["TTO"]="TT";
		$convert3to2["TUN"]="TN";
		$convert3to2["TUR"]="TR";
		$convert3to2["TKM"]="TM";
		$convert3to2["TCA"]="TC";
		$convert3to2["TUV"]="TV";
		$convert3to2["UGA"]="UG";
		$convert3to2["UKR"]="UA";
		$convert3to2["ARE"]="AE";
		$convert3to2["GBR"]="GB";
		$convert3to2["ENG"]="ENGLAND";
		$convert3to2["USA"]="US";
		$convert3to2["UMI"]="UM";
		$convert3to2["URY"]="UY";
		$convert3to2["UZB"]="UZ";
		$convert3to2["VUT"]="VU";
		$convert3to2["VAT"]="VA";
		$convert3to2["VEN"]="VE";
		$convert3to2["VNM"]="VN";
		$convert3to2["WAL"]="WA";
		$convert3to2["VGB"]="VG";
		$convert3to2["VIR"]="VI";
		$convert3to2["WLF"]="WF";
		$convert3to2["ESH"]="EH";
		$convert3to2["YEM"]="YE";
		$convert3to2["YUG"]="YU";
		$convert3to2["ZMB"]="ZM";
		$convert3to2["ZWE"]="ZW";
		
		$convert3to2["URS"]="SU";

		$convert3to2["999"]="99";
		
		$convert3to2["333"]="33";
		$convert3to2["222"]="22";
		$convert3to2["444"]="44";
		$convert3to2["555"]="55";
		$convert3to2["666"]="66";
		$convert3to2["777"]="77";
		$convert3to2["888"]="88";
		
		if (isset($convert3to2[$iso_code_3]))
		{
			return $convert3to2[$iso_code_3];
		}
		return null;
	}

	function getIso3Flag($iso_code_3)
	{
		$iso2=Countries::convertIso3to2($iso_code_3);
		if ($iso2)
		{
			$path=JURI::root().'media/com_joomleague/flags/'.strtolower($iso2).'.png';
			return $path;
		}
		return null;
	}

	/**
	 * example: echo Countries::getCountryFlag($country);
	 *
	 * @param string: an iso3 country code, e.g AUT
	 * @param string: additional html attributes for the img tag
	 * @return string: html code for the flag image
	 */
	function getCountryFlag($countrycode,$attributes='')
	{
		$src=Countries::getIso3Flag($countrycode);
		if (!$src){return '';}
		$html='<img src="'.$src.'" alt="'.Countries::getCountryName($countrycode).'" ';
		$html .= 'title="'.Countries::getCountryName($countrycode).'" '.$attributes.' />';
		return $html;
	}

  /**
   * @param string: an iso3 country code, e.g AUT
   * @return string: a country name
   */
	function getCountryName($iso3)
	{
		$countries=Countries::getCountries();
		if(isset($countries[$iso3]['name']))
		return JText::_($countries[$iso3]['name']);
	}

  /**
   * @param string: an iso3 country code, e.g AUT
   * @return string: a country name, short form
   */
	function getShortCountryName($iso3)
	{
		$full=self::getCountryName($iso3);
		if (empty($full)){return false;}
		$parts=explode(',', $full);
		return JText::_($parts[0]);
	}

/*
Turkish Address-Way:
John Deere Makinalari Limited Sirketi

Centrum Is Merkezi Aydinevler Sanayi Cad. No.3 Kat 4
Küçükyali / Maltepe / Istanbul 34854
Türkiye
*/
	function convertAddressString(	$name='',
									$address='',
									$state='',
									$zipcode='',
									$location='',
									$country='',
									$addressString='%NAME%<br />%ADDRESS%,<br />%STATE%,<br />%ZIPCODE% %LOCATION%,<br />%FLAG% - %COUNTRY%')
	{
		$resultString='';

		if ((!empty($address)) ||
			 (!empty($state))	||
			 (!empty($zipcode)) ||
			 (!empty($location))
		  )
		{
			$dummy=JText::_($addressString);
			$dummy=str_replace('%NAME%',$name,$dummy);
			$dummy=str_replace('%ADDRESS%',$address,$dummy);
			$dummy=str_replace('%STATE%',$state,$dummy);
			$dummy=str_replace('%ZIPCODE%',$zipcode,$dummy);
			$dummy=str_replace('%LOCATION%',$location,$dummy);
			$dummy=str_replace('%FLAG%',Countries::getCountryFlag($country),$dummy);
			$dummy=str_replace('%COUNTRY%',Countries::getCountryName($country),$dummy);
			$resultString .= $dummy;
		}
		$resultString .= '&nbsp;';

		return $resultString;
	}



/*
sort function for countrynames
diddipoeler

*/
function sortStdArray($array,$index)
{
$sort=array() ;
$return=array() ;

for ($i=0; isset($array[$i]); $i++)
$sort[$i]= $array[$i]->{$index};

natcasesort($sort) ;

foreach($sort as $k=>$v)
$return[]=$array[$k] ;

return $return;
}



}
?>