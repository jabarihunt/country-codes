<?php namespace jabarihunt;

    /********************************************************************************
    * Country Codes Class
    *
    * This is a simple class used to get country codes and/or names.  Normally this
    * is something that would be stored and accessed from a database.  However, this
    * class will come in handy in situations where you...
    *
    * 1. Are running your application someplace without access to a database
    * 2. Don't have proper permissions to add tables to a database
    * 3. Outside of a countries table, your application doesn't need a database
    *
    * There are two static functions available to the class...
    *
    * get(int $codeType, string $code, bool $useAPI = FALSE):
    * This function accepts a code type (availabe as class constants) and a
    * corresponding value. The function returns an array containing the country name,
    * 2 letter country code, 3 letter country code, and UN country code.
    *
    * getAll(bool $useAPI = FALSE):
    * Returns a multidemintional array containing the country name, 2 letter country
    * code, 3 letter country code, and UN country code for ALL countries.
    *
    * The countries data is hard coded into the class as an array.  However, each
    * function can be passed an additional parameter ($useAPI) that will span an HTTP
    * request to the REST Countries API to retrieve live data.  It's rare that
    * countries change, but it does happen.  Usage examples are in README.md.
    *
    * Data for this class was obtained from the REST Countries API:
    * https://restcountries.eu/rest/v2/all
    *
    * @author Jabari J. Hunt <jabari@jabari.net>
    ********************************************************************************/

    class CountryCodes
    {
        /********************************************************************************
         * CLASS CONSTANTS
         *
         * @var string COUNTRIES_API_URL
         * @var int CODE_TYPE_COUNTRY_NAME
         * @var int CODE_TYPE_NATIVE_NAME
         * @var int CODE_TYPE_2_LETTER
         * @var int CODE_TYPE_3_LETTER
         * @var int CODE_TYPE_UN
         * @var array CODE_TYPES
         * @var array COUNTRIES
         ********************************************************************************/

            private const COUNTRIES_API_URL = 'https://restcountries.eu/rest/v2/all';

            public const CODE_TYPE_COUNTRY_NAME = 'name';
            public const CODE_TYPE_NATIVE_NAME  = 'nativeName';
            public const CODE_TYPE_2_LETTER     = '2letter';
            public const CODE_TYPE_3_LETTER     = '3letter';
            public const CODE_TYPE_UN           = 'un';

            private const CODE_TYPES =
            [
                self::CODE_TYPE_COUNTRY_NAME,
                self::CODE_TYPE_NATIVE_NAME,
                self::CODE_TYPE_2_LETTER,
                self::CODE_TYPE_3_LETTER,
                self::CODE_TYPE_UN
            ];

            private const COUNTRIES =
            [
                ['name' => 'Afghanistan', 'nativeName' => 'افغانستان', '2letter' => 'AF', '3letter' => 'AFG', 'un' => '004'],
                ['name' => 'Åland Islands', 'nativeName' => 'Åland', '2letter' => 'AX', '3letter' => 'ALA', 'un' => '248'],
                ['name' => 'Albania', 'nativeName' => 'Shqipëria', '2letter' => 'AL', '3letter' => 'ALB', 'un' => '008'],
                ['name' => 'Algeria', 'nativeName' => 'الجزائر', '2letter' => 'DZ', '3letter' => 'DZA', 'un' => '012'],
                ['name' => 'American Samoa', 'nativeName' => 'American Samoa', '2letter' => 'AS', '3letter' => 'ASM', 'un' => '016'],
                ['name' => 'Andorra', 'nativeName' => 'Andorra', '2letter' => 'AD', '3letter' => 'AND', 'un' => '020'],
                ['name' => 'Angola', 'nativeName' => 'Angola', '2letter' => 'AO', '3letter' => 'AGO', 'un' => '024'],
                ['name' => 'Anguilla', 'nativeName' => 'Anguilla', '2letter' => 'AI', '3letter' => 'AIA', 'un' => '660'],
                ['name' => 'Antarctica', 'nativeName' => 'Antarctica', '2letter' => 'AQ', '3letter' => 'ATA', 'un' => '010'],
                ['name' => 'Antigua and Barbuda', 'nativeName' => 'Antigua and Barbuda', '2letter' => 'AG', '3letter' => 'ATG', 'un' => '028'],
                ['name' => 'Argentina', 'nativeName' => 'Argentina', '2letter' => 'AR', '3letter' => 'ARG', 'un' => '032'],
                ['name' => 'Armenia', 'nativeName' => 'Հայաստան', '2letter' => 'AM', '3letter' => 'ARM', 'un' => '051'],
                ['name' => 'Aruba', 'nativeName' => 'Aruba', '2letter' => 'AW', '3letter' => 'ABW', 'un' => '533'],
                ['name' => 'Australia', 'nativeName' => 'Australia', '2letter' => 'AU', '3letter' => 'AUS', 'un' => '036'],
                ['name' => 'Austria', 'nativeName' => 'Österreich', '2letter' => 'AT', '3letter' => 'AUT', 'un' => '040'],
                ['name' => 'Azerbaijan', 'nativeName' => 'Azərbaycan', '2letter' => 'AZ', '3letter' => 'AZE', 'un' => '031'],
                ['name' => 'Bahamas', 'nativeName' => 'Bahamas', '2letter' => 'BS', '3letter' => 'BHS', 'un' => '044'],
                ['name' => 'Bahrain', 'nativeName' => '‏البحرين', '2letter' => 'BH', '3letter' => 'BHR', 'un' => '048'],
                ['name' => 'Bangladesh', 'nativeName' => 'Bangladesh', '2letter' => 'BD', '3letter' => 'BGD', 'un' => '050'],
                ['name' => 'Barbados', 'nativeName' => 'Barbados', '2letter' => 'BB', '3letter' => 'BRB', 'un' => '052'],
                ['name' => 'Belarus', 'nativeName' => 'Белару́сь', '2letter' => 'BY', '3letter' => 'BLR', 'un' => '112'],
                ['name' => 'Belgium', 'nativeName' => 'België', '2letter' => 'BE', '3letter' => 'BEL', 'un' => '056'],
                ['name' => 'Belize', 'nativeName' => 'Belize', '2letter' => 'BZ', '3letter' => 'BLZ', 'un' => '084'],
                ['name' => 'Benin', 'nativeName' => 'Bénin', '2letter' => 'BJ', '3letter' => 'BEN', 'un' => '204'],
                ['name' => 'Bermuda', 'nativeName' => 'Bermuda', '2letter' => 'BM', '3letter' => 'BMU', 'un' => '060'],
                ['name' => 'Bhutan', 'nativeName' => 'ʼbrug-yul', '2letter' => 'BT', '3letter' => 'BTN', 'un' => '064'],
                ['name' => 'Bolivia (Plurinational State of)', 'nativeName' => 'Bolivia', '2letter' => 'BO', '3letter' => 'BOL', 'un' => '068'],
                ['name' => 'Bonaire, Sint Eustatius and Saba', 'nativeName' => 'Bonaire', '2letter' => 'BQ', '3letter' => 'BES', 'un' => '535'],
                ['name' => 'Bosnia and Herzegovina', 'nativeName' => 'Bosna i Hercegovina', '2letter' => 'BA', '3letter' => 'BIH', 'un' => '070'],
                ['name' => 'Botswana', 'nativeName' => 'Botswana', '2letter' => 'BW', '3letter' => 'BWA', 'un' => '072'],
                ['name' => 'Bouvet Island', 'nativeName' => 'Bouvetøya', '2letter' => 'BV', '3letter' => 'BVT', 'un' => '074'],
                ['name' => 'Brazil', 'nativeName' => 'Brasil', '2letter' => 'BR', '3letter' => 'BRA', 'un' => '076'],
                ['name' => 'British Indian Ocean Territory', 'nativeName' => 'British Indian Ocean Territory', '2letter' => 'IO', '3letter' => 'IOT', 'un' => '086'],
                ['name' => 'United States Minor Outlying Islands', 'nativeName' => 'United States Minor Outlying Islands', '2letter' => 'UM', '3letter' => 'UMI', 'un' => '581'],
                ['name' => 'Virgin Islands (British)', 'nativeName' => 'British Virgin Islands', '2letter' => 'VG', '3letter' => 'VGB', 'un' => '092'],
                ['name' => 'Virgin Islands (U.S.)', 'nativeName' => 'Virgin Islands of the United States', '2letter' => 'VI', '3letter' => 'VIR', 'un' => '850'],
                ['name' => 'Brunei Darussalam', 'nativeName' => 'Negara Brunei Darussalam', '2letter' => 'BN', '3letter' => 'BRN', 'un' => '096'],
                ['name' => 'Bulgaria', 'nativeName' => 'България', '2letter' => 'BG', '3letter' => 'BGR', 'un' => '100'],
                ['name' => 'Burkina Faso', 'nativeName' => 'Burkina Faso', '2letter' => 'BF', '3letter' => 'BFA', 'un' => '854'],
                ['name' => 'Burundi', 'nativeName' => 'Burundi', '2letter' => 'BI', '3letter' => 'BDI', 'un' => '108'],
                ['name' => 'Cambodia', 'nativeName' => 'Kâmpŭchéa', '2letter' => 'KH', '3letter' => 'KHM', 'un' => '116'],
                ['name' => 'Cameroon', 'nativeName' => 'Cameroon', '2letter' => 'CM', '3letter' => 'CMR', 'un' => '120'],
                ['name' => 'Canada', 'nativeName' => 'Canada', '2letter' => 'CA', '3letter' => 'CAN', 'un' => '124'],
                ['name' => 'Cabo Verde', 'nativeName' => 'Cabo Verde', '2letter' => 'CV', '3letter' => 'CPV', 'un' => '132'],
                ['name' => 'Cayman Islands', 'nativeName' => 'Cayman Islands', '2letter' => 'KY', '3letter' => 'CYM', 'un' => '136'],
                ['name' => 'Central African Republic', 'nativeName' => 'Ködörösêse tî Bêafrîka', '2letter' => 'CF', '3letter' => 'CAF', 'un' => '140'],
                ['name' => 'Chad', 'nativeName' => 'Tchad', '2letter' => 'TD', '3letter' => 'TCD', 'un' => '148'],
                ['name' => 'Chile', 'nativeName' => 'Chile', '2letter' => 'CL', '3letter' => 'CHL', 'un' => '152'],
                ['name' => 'China', 'nativeName' => '中国', '2letter' => 'CN', '3letter' => 'CHN', 'un' => '156'],
                ['name' => 'Christmas Island', 'nativeName' => 'Christmas Island', '2letter' => 'CX', '3letter' => 'CXR', 'un' => '162'],
                ['name' => 'Cocos (Keeling) Islands', 'nativeName' => 'Cocos (Keeling) Islands', '2letter' => 'CC', '3letter' => 'CCK', 'un' => '166'],
                ['name' => 'Colombia', 'nativeName' => 'Colombia', '2letter' => 'CO', '3letter' => 'COL', 'un' => '170'],
                ['name' => 'Comoros', 'nativeName' => 'Komori', '2letter' => 'KM', '3letter' => 'COM', 'un' => '174'],
                ['name' => 'Congo', 'nativeName' => 'République du Congo', '2letter' => 'CG', '3letter' => 'COG', 'un' => '178'],
                ['name' => 'Congo (Democratic Republic of the)', 'nativeName' => 'République démocratique du Congo', '2letter' => 'CD', '3letter' => 'COD', 'un' => '180'],
                ['name' => 'Cook Islands', 'nativeName' => 'Cook Islands', '2letter' => 'CK', '3letter' => 'COK', 'un' => '184'],
                ['name' => 'Costa Rica', 'nativeName' => 'Costa Rica', '2letter' => 'CR', '3letter' => 'CRI', 'un' => '188'],
                ['name' => 'Croatia', 'nativeName' => 'Hrvatska', '2letter' => 'HR', '3letter' => 'HRV', 'un' => '191'],
                ['name' => 'Cuba', 'nativeName' => 'Cuba', '2letter' => 'CU', '3letter' => 'CUB', 'un' => '192'],
                ['name' => 'Curaçao', 'nativeName' => 'Curaçao', '2letter' => 'CW', '3letter' => 'CUW', 'un' => '531'],
                ['name' => 'Cyprus', 'nativeName' => 'Κύπρος', '2letter' => 'CY', '3letter' => 'CYP', 'un' => '196'],
                ['name' => 'Czech Republic', 'nativeName' => 'Česká republika', '2letter' => 'CZ', '3letter' => 'CZE', 'un' => '203'],
                ['name' => 'Denmark', 'nativeName' => 'Danmark', '2letter' => 'DK', '3letter' => 'DNK', 'un' => '208'],
                ['name' => 'Djibouti', 'nativeName' => 'Djibouti', '2letter' => 'DJ', '3letter' => 'DJI', 'un' => '262'],
                ['name' => 'Dominica', 'nativeName' => 'Dominica', '2letter' => 'DM', '3letter' => 'DMA', 'un' => '212'],
                ['name' => 'Dominican Republic', 'nativeName' => 'República Dominicana', '2letter' => 'DO', '3letter' => 'DOM', 'un' => '214'],
                ['name' => 'Ecuador', 'nativeName' => 'Ecuador', '2letter' => 'EC', '3letter' => 'ECU', 'un' => '218'],
                ['name' => 'Egypt', 'nativeName' => 'مصر‎', '2letter' => 'EG', '3letter' => 'EGY', 'un' => '818'],
                ['name' => 'El Salvador', 'nativeName' => 'El Salvador', '2letter' => 'SV', '3letter' => 'SLV', 'un' => '222'],
                ['name' => 'Equatorial Guinea', 'nativeName' => 'Guinea Ecuatorial', '2letter' => 'GQ', '3letter' => 'GNQ', 'un' => '226'],
                ['name' => 'Eritrea', 'nativeName' => 'ኤርትራ', '2letter' => 'ER', '3letter' => 'ERI', 'un' => '232'],
                ['name' => 'Estonia', 'nativeName' => 'Eesti', '2letter' => 'EE', '3letter' => 'EST', 'un' => '233'],
                ['name' => 'Ethiopia', 'nativeName' => 'ኢትዮጵያ', '2letter' => 'ET', '3letter' => 'ETH', 'un' => '231'],
                ['name' => 'Falkland Islands (Malvinas)', 'nativeName' => 'Falkland Islands', '2letter' => 'FK', '3letter' => 'FLK', 'un' => '238'],
                ['name' => 'Faroe Islands', 'nativeName' => 'Føroyar', '2letter' => 'FO', '3letter' => 'FRO', 'un' => '234'],
                ['name' => 'Fiji', 'nativeName' => 'Fiji', '2letter' => 'FJ', '3letter' => 'FJI', 'un' => '242'],
                ['name' => 'Finland', 'nativeName' => 'Suomi', '2letter' => 'FI', '3letter' => 'FIN', 'un' => '246'],
                ['name' => 'France', 'nativeName' => 'France', '2letter' => 'FR', '3letter' => 'FRA', 'un' => '250'],
                ['name' => 'French Guiana', 'nativeName' => 'Guyane française', '2letter' => 'GF', '3letter' => 'GUF', 'un' => '254'],
                ['name' => 'French Polynesia', 'nativeName' => 'Polynésie française', '2letter' => 'PF', '3letter' => 'PYF', 'un' => '258'],
                ['name' => 'French Southern Territories', 'nativeName' => 'Territoire des Terres australes et antarctiques françaises', '2letter' => 'TF', '3letter' => 'ATF', 'un' => '260'],
                ['name' => 'Gabon', 'nativeName' => 'Gabon', '2letter' => 'GA', '3letter' => 'GAB', 'un' => '266'],
                ['name' => 'Gambia', 'nativeName' => 'Gambia', '2letter' => 'GM', '3letter' => 'GMB', 'un' => '270'],
                ['name' => 'Georgia', 'nativeName' => 'საქართველო', '2letter' => 'GE', '3letter' => 'GEO', 'un' => '268'],
                ['name' => 'Germany', 'nativeName' => 'Deutschland', '2letter' => 'DE', '3letter' => 'DEU', 'un' => '276'],
                ['name' => 'Ghana', 'nativeName' => 'Ghana', '2letter' => 'GH', '3letter' => 'GHA', 'un' => '288'],
                ['name' => 'Gibraltar', 'nativeName' => 'Gibraltar', '2letter' => 'GI', '3letter' => 'GIB', 'un' => '292'],
                ['name' => 'Greece', 'nativeName' => 'Ελλάδα', '2letter' => 'GR', '3letter' => 'GRC', 'un' => '300'],
                ['name' => 'Greenland', 'nativeName' => 'Kalaallit Nunaat', '2letter' => 'GL', '3letter' => 'GRL', 'un' => '304'],
                ['name' => 'Grenada', 'nativeName' => 'Grenada', '2letter' => 'GD', '3letter' => 'GRD', 'un' => '308'],
                ['name' => 'Guadeloupe', 'nativeName' => 'Guadeloupe', '2letter' => 'GP', '3letter' => 'GLP', 'un' => '312'],
                ['name' => 'Guam', 'nativeName' => 'Guam', '2letter' => 'GU', '3letter' => 'GUM', 'un' => '316'],
                ['name' => 'Guatemala', 'nativeName' => 'Guatemala', '2letter' => 'GT', '3letter' => 'GTM', 'un' => '320'],
                ['name' => 'Guernsey', 'nativeName' => 'Guernsey', '2letter' => 'GG', '3letter' => 'GGY', 'un' => '831'],
                ['name' => 'Guinea', 'nativeName' => 'Guinée', '2letter' => 'GN', '3letter' => 'GIN', 'un' => '324'],
                ['name' => 'Guinea-Bissau', 'nativeName' => 'Guiné-Bissau', '2letter' => 'GW', '3letter' => 'GNB', 'un' => '624'],
                ['name' => 'Guyana', 'nativeName' => 'Guyana', '2letter' => 'GY', '3letter' => 'GUY', 'un' => '328'],
                ['name' => 'Haiti', 'nativeName' => 'Haïti', '2letter' => 'HT', '3letter' => 'HTI', 'un' => '332'],
                ['name' => 'Heard Island and McDonald Islands', 'nativeName' => 'Heard Island and McDonald Islands', '2letter' => 'HM', '3letter' => 'HMD', 'un' => '334'],
                ['name' => 'Holy See', 'nativeName' => 'Sancta Sedes', '2letter' => 'VA', '3letter' => 'VAT', 'un' => '336'],
                ['name' => 'Honduras', 'nativeName' => 'Honduras', '2letter' => 'HN', '3letter' => 'HND', 'un' => '340'],
                ['name' => 'Hong Kong', 'nativeName' => '香港', '2letter' => 'HK', '3letter' => 'HKG', 'un' => '344'],
                ['name' => 'Hungary', 'nativeName' => 'Magyarország', '2letter' => 'HU', '3letter' => 'HUN', 'un' => '348'],
                ['name' => 'Iceland', 'nativeName' => 'Ísland', '2letter' => 'IS', '3letter' => 'ISL', 'un' => '352'],
                ['name' => 'India', 'nativeName' => 'भारत', '2letter' => 'IN', '3letter' => 'IND', 'un' => '356'],
                ['name' => 'Indonesia', 'nativeName' => 'Indonesia', '2letter' => 'ID', '3letter' => 'IDN', 'un' => '360'],
                ['name' => 'Côte d\'Ivoire', 'nativeName' => 'Côte d\'Ivoire', '2letter' => 'CI', '3letter' => 'CIV', 'un' => '384'],
                ['name' => 'Iran (Islamic Republic of)', 'nativeName' => 'ایران', '2letter' => 'IR', '3letter' => 'IRN', 'un' => '364'],
                ['name' => 'Iraq', 'nativeName' => 'العراق', '2letter' => 'IQ', '3letter' => 'IRQ', 'un' => '368'],
                ['name' => 'Ireland', 'nativeName' => 'Éire', '2letter' => 'IE', '3letter' => 'IRL', 'un' => '372'],
                ['name' => 'Isle of Man', 'nativeName' => 'Isle of Man', '2letter' => 'IM', '3letter' => 'IMN', 'un' => '833'],
                ['name' => 'Israel', 'nativeName' => 'יִשְׂרָאֵל', '2letter' => 'IL', '3letter' => 'ISR', 'un' => '376'],
                ['name' => 'Italy', 'nativeName' => 'Italia', '2letter' => 'IT', '3letter' => 'ITA', 'un' => '380'],
                ['name' => 'Jamaica', 'nativeName' => 'Jamaica', '2letter' => 'JM', '3letter' => 'JAM', 'un' => '388'],
                ['name' => 'Japan', 'nativeName' => '日本', '2letter' => 'JP', '3letter' => 'JPN', 'un' => '392'],
                ['name' => 'Jersey', 'nativeName' => 'Jersey', '2letter' => 'JE', '3letter' => 'JEY', 'un' => '832'],
                ['name' => 'Jordan', 'nativeName' => 'الأردن', '2letter' => 'JO', '3letter' => 'JOR', 'un' => '400'],
                ['name' => 'Kazakhstan', 'nativeName' => 'Қазақстан', '2letter' => 'KZ', '3letter' => 'KAZ', 'un' => '398'],
                ['name' => 'Kenya', 'nativeName' => 'Kenya', '2letter' => 'KE', '3letter' => 'KEN', 'un' => '404'],
                ['name' => 'Kiribati', 'nativeName' => 'Kiribati', '2letter' => 'KI', '3letter' => 'KIR', 'un' => '296'],
                ['name' => 'Kuwait', 'nativeName' => 'الكويت', '2letter' => 'KW', '3letter' => 'KWT', 'un' => '414'],
                ['name' => 'Kyrgyzstan', 'nativeName' => 'Кыргызстан', '2letter' => 'KG', '3letter' => 'KGZ', 'un' => '417'],
                ['name' => 'Lao People\'s Democratic Republic', 'nativeName' => 'ສປປລາວ', '2letter' => 'LA', '3letter' => 'LAO', 'un' => '418'],
                ['name' => 'Latvia', 'nativeName' => 'Latvija', '2letter' => 'LV', '3letter' => 'LVA', 'un' => '428'],
                ['name' => 'Lebanon', 'nativeName' => 'لبنان', '2letter' => 'LB', '3letter' => 'LBN', 'un' => '422'],
                ['name' => 'Lesotho', 'nativeName' => 'Lesotho', '2letter' => 'LS', '3letter' => 'LSO', 'un' => '426'],
                ['name' => 'Liberia', 'nativeName' => 'Liberia', '2letter' => 'LR', '3letter' => 'LBR', 'un' => '430'],
                ['name' => 'Libya', 'nativeName' => '‏ليبيا', '2letter' => 'LY', '3letter' => 'LBY', 'un' => '434'],
                ['name' => 'Liechtenstein', 'nativeName' => 'Liechtenstein', '2letter' => 'LI', '3letter' => 'LIE', 'un' => '438'],
                ['name' => 'Lithuania', 'nativeName' => 'Lietuva', '2letter' => 'LT', '3letter' => 'LTU', 'un' => '440'],
                ['name' => 'Luxembourg', 'nativeName' => 'Luxembourg', '2letter' => 'LU', '3letter' => 'LUX', 'un' => '442'],
                ['name' => 'Macao', 'nativeName' => '澳門', '2letter' => 'MO', '3letter' => 'MAC', 'un' => '446'],
                ['name' => 'Macedonia (the former Yugoslav Republic of)', 'nativeName' => 'Македонија', '2letter' => 'MK', '3letter' => 'MKD', 'un' => '807'],
                ['name' => 'Madagascar', 'nativeName' => 'Madagasikara', '2letter' => 'MG', '3letter' => 'MDG', 'un' => '450'],
                ['name' => 'Malawi', 'nativeName' => 'Malawi', '2letter' => 'MW', '3letter' => 'MWI', 'un' => '454'],
                ['name' => 'Malaysia', 'nativeName' => 'Malaysia', '2letter' => 'MY', '3letter' => 'MYS', 'un' => '458'],
                ['name' => 'Maldives', 'nativeName' => 'Maldives', '2letter' => 'MV', '3letter' => 'MDV', 'un' => '462'],
                ['name' => 'Mali', 'nativeName' => 'Mali', '2letter' => 'ML', '3letter' => 'MLI', 'un' => '466'],
                ['name' => 'Malta', 'nativeName' => 'Malta', '2letter' => 'MT', '3letter' => 'MLT', 'un' => '470'],
                ['name' => 'Marshall Islands', 'nativeName' => 'M̧ajeļ', '2letter' => 'MH', '3letter' => 'MHL', 'un' => '584'],
                ['name' => 'Martinique', 'nativeName' => 'Martinique', '2letter' => 'MQ', '3letter' => 'MTQ', 'un' => '474'],
                ['name' => 'Mauritania', 'nativeName' => 'موريتانيا', '2letter' => 'MR', '3letter' => 'MRT', 'un' => '478'],
                ['name' => 'Mauritius', 'nativeName' => 'Maurice', '2letter' => 'MU', '3letter' => 'MUS', 'un' => '480'],
                ['name' => 'Mayotte', 'nativeName' => 'Mayotte', '2letter' => 'YT', '3letter' => 'MYT', 'un' => '175'],
                ['name' => 'Mexico', 'nativeName' => 'México', '2letter' => 'MX', '3letter' => 'MEX', 'un' => '484'],
                ['name' => 'Micronesia (Federated States of)', 'nativeName' => 'Micronesia', '2letter' => 'FM', '3letter' => 'FSM', 'un' => '583'],
                ['name' => 'Moldova (Republic of)', 'nativeName' => 'Moldova', '2letter' => 'MD', '3letter' => 'MDA', 'un' => '498'],
                ['name' => 'Monaco', 'nativeName' => 'Monaco', '2letter' => 'MC', '3letter' => 'MCO', 'un' => '492'],
                ['name' => 'Mongolia', 'nativeName' => 'Монгол улс', '2letter' => 'MN', '3letter' => 'MNG', 'un' => '496'],
                ['name' => 'Montenegro', 'nativeName' => 'Црна Гора', '2letter' => 'ME', '3letter' => 'MNE', 'un' => '499'],
                ['name' => 'Montserrat', 'nativeName' => 'Montserrat', '2letter' => 'MS', '3letter' => 'MSR', 'un' => '500'],
                ['name' => 'Morocco', 'nativeName' => 'المغرب', '2letter' => 'MA', '3letter' => 'MAR', 'un' => '504'],
                ['name' => 'Mozambique', 'nativeName' => 'Moçambique', '2letter' => 'MZ', '3letter' => 'MOZ', 'un' => '508'],
                ['name' => 'Myanmar', 'nativeName' => 'Myanma', '2letter' => 'MM', '3letter' => 'MMR', 'un' => '104'],
                ['name' => 'Namibia', 'nativeName' => 'Namibia', '2letter' => 'NA', '3letter' => 'NAM', 'un' => '516'],
                ['name' => 'Nauru', 'nativeName' => 'Nauru', '2letter' => 'NR', '3letter' => 'NRU', 'un' => '520'],
                ['name' => 'Nepal', 'nativeName' => 'नेपाल', '2letter' => 'NP', '3letter' => 'NPL', 'un' => '524'],
                ['name' => 'Netherlands', 'nativeName' => 'Nederland', '2letter' => 'NL', '3letter' => 'NLD', 'un' => '528'],
                ['name' => 'New Caledonia', 'nativeName' => 'Nouvelle-Calédonie', '2letter' => 'NC', '3letter' => 'NCL', 'un' => '540'],
                ['name' => 'New Zealand', 'nativeName' => 'New Zealand', '2letter' => 'NZ', '3letter' => 'NZL', 'un' => '554'],
                ['name' => 'Nicaragua', 'nativeName' => 'Nicaragua', '2letter' => 'NI', '3letter' => 'NIC', 'un' => '558'],
                ['name' => 'Niger', 'nativeName' => 'Niger', '2letter' => 'NE', '3letter' => 'NER', 'un' => '562'],
                ['name' => 'Nigeria', 'nativeName' => 'Nigeria', '2letter' => 'NG', '3letter' => 'NGA', 'un' => '566'],
                ['name' => 'Niue', 'nativeName' => 'Niuē', '2letter' => 'NU', '3letter' => 'NIU', 'un' => '570'],
                ['name' => 'Norfolk Island', 'nativeName' => 'Norfolk Island', '2letter' => 'NF', '3letter' => 'NFK', 'un' => '574'],
                ['name' => 'Korea (Democratic People\'s Republic of)', 'nativeName' => '북한', '2letter' => 'KP', '3letter' => 'PRK', 'un' => '408'],
                ['name' => 'Northern Mariana Islands', 'nativeName' => 'Northern Mariana Islands', '2letter' => 'MP', '3letter' => 'MNP', 'un' => '580'],
                ['name' => 'Norway', 'nativeName' => 'Norge', '2letter' => 'NO', '3letter' => 'NOR', 'un' => '578'],
                ['name' => 'Oman', 'nativeName' => 'عمان', '2letter' => 'OM', '3letter' => 'OMN', 'un' => '512'],
                ['name' => 'Pakistan', 'nativeName' => 'Pakistan', '2letter' => 'PK', '3letter' => 'PAK', 'un' => '586'],
                ['name' => 'Palau', 'nativeName' => 'Palau', '2letter' => 'PW', '3letter' => 'PLW', 'un' => '585'],
                ['name' => 'Palestine, State of', 'nativeName' => 'فلسطين', '2letter' => 'PS', '3letter' => 'PSE', 'un' => '275'],
                ['name' => 'Panama', 'nativeName' => 'Panamá', '2letter' => 'PA', '3letter' => 'PAN', 'un' => '591'],
                ['name' => 'Papua New Guinea', 'nativeName' => 'Papua Niugini', '2letter' => 'PG', '3letter' => 'PNG', 'un' => '598'],
                ['name' => 'Paraguay', 'nativeName' => 'Paraguay', '2letter' => 'PY', '3letter' => 'PRY', 'un' => '600'],
                ['name' => 'Peru', 'nativeName' => 'Perú', '2letter' => 'PE', '3letter' => 'PER', 'un' => '604'],
                ['name' => 'Philippines', 'nativeName' => 'Pilipinas', '2letter' => 'PH', '3letter' => 'PHL', 'un' => '608'],
                ['name' => 'Pitcairn', 'nativeName' => 'Pitcairn Islands', '2letter' => 'PN', '3letter' => 'PCN', 'un' => '612'],
                ['name' => 'Poland', 'nativeName' => 'Polska', '2letter' => 'PL', '3letter' => 'POL', 'un' => '616'],
                ['name' => 'Portugal', 'nativeName' => 'Portugal', '2letter' => 'PT', '3letter' => 'PRT', 'un' => '620'],
                ['name' => 'Puerto Rico', 'nativeName' => 'Puerto Rico', '2letter' => 'PR', '3letter' => 'PRI', 'un' => '630'],
                ['name' => 'Qatar', 'nativeName' => 'قطر', '2letter' => 'QA', '3letter' => 'QAT', 'un' => '634'],
                ['name' => 'Republic of Kosovo', 'nativeName' => 'Republika e Kosovës', '2letter' => 'XK', '3letter' => 'KOS', 'un' => ''],
                ['name' => 'Réunion', 'nativeName' => 'La Réunion', '2letter' => 'RE', '3letter' => 'REU', 'un' => '638'],
                ['name' => 'Romania', 'nativeName' => 'România', '2letter' => 'RO', '3letter' => 'ROU', 'un' => '642'],
                ['name' => 'Russian Federation', 'nativeName' => 'Россия', '2letter' => 'RU', '3letter' => 'RUS', 'un' => '643'],
                ['name' => 'Rwanda', 'nativeName' => 'Rwanda', '2letter' => 'RW', '3letter' => 'RWA', 'un' => '646'],
                ['name' => 'Saint Barthélemy', 'nativeName' => 'Saint-Barthélemy', '2letter' => 'BL', '3letter' => 'BLM', 'un' => '652'],
                ['name' => 'Saint Helena, Ascension and Tristan da Cunha', 'nativeName' => 'Saint Helena', '2letter' => 'SH', '3letter' => 'SHN', 'un' => '654'],
                ['name' => 'Saint Kitts and Nevis', 'nativeName' => 'Saint Kitts and Nevis', '2letter' => 'KN', '3letter' => 'KNA', 'un' => '659'],
                ['name' => 'Saint Lucia', 'nativeName' => 'Saint Lucia', '2letter' => 'LC', '3letter' => 'LCA', 'un' => '662'],
                ['name' => 'Saint Martin (French part)', 'nativeName' => 'Saint-Martin', '2letter' => 'MF', '3letter' => 'MAF', 'un' => '663'],
                ['name' => 'Saint Pierre and Miquelon', 'nativeName' => 'Saint-Pierre-et-Miquelon', '2letter' => 'PM', '3letter' => 'SPM', 'un' => '666'],
                ['name' => 'Saint Vincent and the Grenadines', 'nativeName' => 'Saint Vincent and the Grenadines', '2letter' => 'VC', '3letter' => 'VCT', 'un' => '670'],
                ['name' => 'Samoa', 'nativeName' => 'Samoa', '2letter' => 'WS', '3letter' => 'WSM', 'un' => '882'],
                ['name' => 'San Marino', 'nativeName' => 'San Marino', '2letter' => 'SM', '3letter' => 'SMR', 'un' => '674'],
                ['name' => 'Sao Tome and Principe', 'nativeName' => 'São Tomé e Príncipe', '2letter' => 'ST', '3letter' => 'STP', 'un' => '678'],
                ['name' => 'Saudi Arabia', 'nativeName' => 'العربية السعودية', '2letter' => 'SA', '3letter' => 'SAU', 'un' => '682'],
                ['name' => 'Senegal', 'nativeName' => 'Sénégal', '2letter' => 'SN', '3letter' => 'SEN', 'un' => '686'],
                ['name' => 'Serbia', 'nativeName' => 'Србија', '2letter' => 'RS', '3letter' => 'SRB', 'un' => '688'],
                ['name' => 'Seychelles', 'nativeName' => 'Seychelles', '2letter' => 'SC', '3letter' => 'SYC', 'un' => '690'],
                ['name' => 'Sierra Leone', 'nativeName' => 'Sierra Leone', '2letter' => 'SL', '3letter' => 'SLE', 'un' => '694'],
                ['name' => 'Singapore', 'nativeName' => 'Singapore', '2letter' => 'SG', '3letter' => 'SGP', 'un' => '702'],
                ['name' => 'Sint Maarten (Dutch part)', 'nativeName' => 'Sint Maarten', '2letter' => 'SX', '3letter' => 'SXM', 'un' => '534'],
                ['name' => 'Slovakia', 'nativeName' => 'Slovensko', '2letter' => 'SK', '3letter' => 'SVK', 'un' => '703'],
                ['name' => 'Slovenia', 'nativeName' => 'Slovenija', '2letter' => 'SI', '3letter' => 'SVN', 'un' => '705'],
                ['name' => 'Solomon Islands', 'nativeName' => 'Solomon Islands', '2letter' => 'SB', '3letter' => 'SLB', 'un' => '090'],
                ['name' => 'Somalia', 'nativeName' => 'Soomaaliya', '2letter' => 'SO', '3letter' => 'SOM', 'un' => '706'],
                ['name' => 'South Africa', 'nativeName' => 'South Africa', '2letter' => 'ZA', '3letter' => 'ZAF', 'un' => '710'],
                ['name' => 'South Georgia and the South Sandwich Islands', 'nativeName' => 'South Georgia', '2letter' => 'GS', '3letter' => 'SGS', 'un' => '239'],
                ['name' => 'Korea (Republic of)', 'nativeName' => '대한민국', '2letter' => 'KR', '3letter' => 'KOR', 'un' => '410'],
                ['name' => 'South Sudan', 'nativeName' => 'South Sudan', '2letter' => 'SS', '3letter' => 'SSD', 'un' => '728'],
                ['name' => 'Spain', 'nativeName' => 'España', '2letter' => 'ES', '3letter' => 'ESP', 'un' => '724'],
                ['name' => 'Sri Lanka', 'nativeName' => 'śrī laṃkāva', '2letter' => 'LK', '3letter' => 'LKA', 'un' => '144'],
                ['name' => 'Sudan', 'nativeName' => 'السودان', '2letter' => 'SD', '3letter' => 'SDN', 'un' => '729'],
                ['name' => 'Suriname', 'nativeName' => 'Suriname', '2letter' => 'SR', '3letter' => 'SUR', 'un' => '740'],
                ['name' => 'Svalbard and Jan Mayen', 'nativeName' => 'Svalbard og Jan Mayen', '2letter' => 'SJ', '3letter' => 'SJM', 'un' => '744'],
                ['name' => 'Swaziland', 'nativeName' => 'Swaziland', '2letter' => 'SZ', '3letter' => 'SWZ', 'un' => '748'],
                ['name' => 'Sweden', 'nativeName' => 'Sverige', '2letter' => 'SE', '3letter' => 'SWE', 'un' => '752'],
                ['name' => 'Switzerland', 'nativeName' => 'Schweiz', '2letter' => 'CH', '3letter' => 'CHE', 'un' => '756'],
                ['name' => 'Syrian Arab Republic', 'nativeName' => 'سوريا', '2letter' => 'SY', '3letter' => 'SYR', 'un' => '760'],
                ['name' => 'Taiwan', 'nativeName' => '臺灣', '2letter' => 'TW', '3letter' => 'TWN', 'un' => '158'],
                ['name' => 'Tajikistan', 'nativeName' => 'Тоҷикистон', '2letter' => 'TJ', '3letter' => 'TJK', 'un' => '762'],
                ['name' => 'Tanzania, United Republic of', 'nativeName' => 'Tanzania', '2letter' => 'TZ', '3letter' => 'TZA', 'un' => '834'],
                ['name' => 'Thailand', 'nativeName' => 'ประเทศไทย', '2letter' => 'TH', '3letter' => 'THA', 'un' => '764'],
                ['name' => 'Timor-Leste', 'nativeName' => 'Timor-Leste', '2letter' => 'TL', '3letter' => 'TLS', 'un' => '626'],
                ['name' => 'Togo', 'nativeName' => 'Togo', '2letter' => 'TG', '3letter' => 'TGO', 'un' => '768'],
                ['name' => 'Tokelau', 'nativeName' => 'Tokelau', '2letter' => 'TK', '3letter' => 'TKL', 'un' => '772'],
                ['name' => 'Tonga', 'nativeName' => 'Tonga', '2letter' => 'TO', '3letter' => 'TON', 'un' => '776'],
                ['name' => 'Trinidad and Tobago', 'nativeName' => 'Trinidad and Tobago', '2letter' => 'TT', '3letter' => 'TTO', 'un' => '780'],
                ['name' => 'Tunisia', 'nativeName' => 'تونس', '2letter' => 'TN', '3letter' => 'TUN', 'un' => '788'],
                ['name' => 'Turkey', 'nativeName' => 'Türkiye', '2letter' => 'TR', '3letter' => 'TUR', 'un' => '792'],
                ['name' => 'Turkmenistan', 'nativeName' => 'Türkmenistan', '2letter' => 'TM', '3letter' => 'TKM', 'un' => '795'],
                ['name' => 'Turks and Caicos Islands', 'nativeName' => 'Turks and Caicos Islands', '2letter' => 'TC', '3letter' => 'TCA', 'un' => '796'],
                ['name' => 'Tuvalu', 'nativeName' => 'Tuvalu', '2letter' => 'TV', '3letter' => 'TUV', 'un' => '798'],
                ['name' => 'Uganda', 'nativeName' => 'Uganda', '2letter' => 'UG', '3letter' => 'UGA', 'un' => '800'],
                ['name' => 'Ukraine', 'nativeName' => 'Україна', '2letter' => 'UA', '3letter' => 'UKR', 'un' => '804'],
                ['name' => 'United Arab Emirates', 'nativeName' => 'دولة الإمارات العربية المتحدة', '2letter' => 'AE', '3letter' => 'ARE', 'un' => '784'],
                ['name' => 'United Kingdom of Great Britain and Northern Ireland', 'nativeName' => 'United Kingdom', '2letter' => 'GB', '3letter' => 'GBR', 'un' => '826'],
                ['name' => 'United States of America', 'nativeName' => 'United States', '2letter' => 'US', '3letter' => 'USA', 'un' => '840'],
                ['name' => 'Uruguay', 'nativeName' => 'Uruguay', '2letter' => 'UY', '3letter' => 'URY', 'un' => '858'],
                ['name' => 'Uzbekistan', 'nativeName' => 'O‘zbekiston', '2letter' => 'UZ', '3letter' => 'UZB', 'un' => '860'],
                ['name' => 'Vanuatu', 'nativeName' => 'Vanuatu', '2letter' => 'VU', '3letter' => 'VUT', 'un' => '548'],
                ['name' => 'Venezuela (Bolivarian Republic of)', 'nativeName' => 'Venezuela', '2letter' => 'VE', '3letter' => 'VEN', 'un' => '862'],
                ['name' => 'Viet Nam', 'nativeName' => 'Việt Nam', '2letter' => 'VN', '3letter' => 'VNM', 'un' => '704'],
                ['name' => 'Wallis and Futuna', 'nativeName' => 'Wallis et Futuna', '2letter' => 'WF', '3letter' => 'WLF', 'un' => '876'],
                ['name' => 'Western Sahara', 'nativeName' => 'الصحراء الغربية', '2letter' => 'EH', '3letter' => 'ESH', 'un' => '732'],
                ['name' => 'Yemen', 'nativeName' => 'اليَمَن', '2letter' => 'YE', '3letter' => 'YEM', 'un' => '887'],
                ['name' => 'Zambia', 'nativeName' => 'Zambia', '2letter' => 'ZM', '3letter' => 'ZMB', 'un' => '894'],
                ['name' => 'Zimbabwe', 'nativeName' => 'Zimbabwe', '2letter' => 'ZW', '3letter' => 'ZWE', 'un' => '716']
            ];

        /********************************************************************************
         * GET METHOD
         *
         * @param int $codeType
         * @param string $code
         * @param bool $useAPI Defaults to FALSE
         * @return array
         ********************************************************************************/

            public static function get(string $codeType, string $code, bool $useAPI = FALSE): array
            {
                // FORMAT CODE | VALIDATE PASSED CODE DATA

                    $code = strtoupper(trim($code));

                    if (in_array($codeType, self::CODE_TYPES) && !empty($code))
                    {
                        // GET COUNTRIES -> LOOP THROUGH AND FIND A MATCH

                            $countries = self::getAll($useAPI);

                            if (!empty($countries) && is_array($countries))
                            {
                                foreach ($countries as $key => $country)
                                {
                                    if ($code === strtoupper($country[$codeType]))
                                    {
                                        $selectedCountry = $countries[$key];
                                        break;
                                    }
                                }
                            }
                    }

                // RETURN SELECTED COUNTRY

                    return !empty($selectedCountry) ? $selectedCountry : [];
            }

        /********************************************************************************
         * GET ALL METHOD
         *
         * @param bool $useAPI Defaults to FALSE
         * @return array
         ********************************************************************************/

            public static function getAll(bool $useAPI = FALSE): array
            {
                return $useAPI ? self::getCountriesFromAPI() : self::COUNTRIES;
            }

        /********************************************************************************
         * GET COUNTRIES FROM API METHOD
         *
         * @return array
         ********************************************************************************/

            private static function getCountriesFromAPI(): array
            {
                // PREPARE HTTPS REQUEST (VIA CURL) | MAKE CURL REQUEST

                    $curl = curl_init();

                    curl_setopt($curl, CURLOPT_URL, self::COUNTRIES_API_URL);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HEADER, false);

                    $response = curl_exec($curl);

                // MAKE SURE EXPECTED RESPONSE WAS RECEIVED -> CREATE COUNTRIES ARRAY FROM DECODED JSON

                    if (curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200 && strlen($response) > 0)
                    {
                        foreach (json_decode($response) as $data)
                        {
                            $countries[] =
                            [
                                self::CODE_TYPE_COUNTRY_NAME => str_replace("'", "\'", $data->name),
                                self::CODE_TYPE_NATIVE_NAME  => str_replace("'", "\'", $data->nativeName),
                                self::CODE_TYPE_2_LETTER     => $data->alpha2Code,
                                self::CODE_TYPE_3_LETTER     => $data->alpha3Code,
                                self::CODE_TYPE_UN           => $data->numericCode
                            ];
                        }
                    }

                // CLOSE CURL CONNECTION | RETURN COUNTRIES

                    curl_close($curl);
                    return !empty($countries) ? $countries : [];
            }
    }

?>