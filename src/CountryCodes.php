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

            public const CODE_TYPE_COUNTRY_NAME = 0;
            public const CODE_TYPE_NATIVE_NAME  = 1;
            public const CODE_TYPE_2_LETTER     = 2;
            public const CODE_TYPE_3_LETTER     = 3;
            public const CODE_TYPE_UN           = 4;

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
                [ 0 => 'Afghanistan', 1 => 'افغانستان', 2 => 'AF', 3 => 'AFG', 4 => '004'],
                [ 0 => 'Åland Islands', 1 => 'Åland', 2 => 'AX', 3 => 'ALA', 4 => '248'],
                [ 0 => 'Albania', 1 => 'Shqipëria', 2 => 'AL', 3 => 'ALB', 4 => '008'],
                [ 0 => 'Algeria', 1 => 'الجزائر', 2 => 'DZ', 3 => 'DZA', 4 => '012'],
                [ 0 => 'American Samoa', 1 => 'American Samoa', 2 => 'AS', 3 => 'ASM', 4 => '016'],
                [ 0 => 'Andorra', 1 => 'Andorra', 2 => 'AD', 3 => 'AND', 4 => '020'],
                [ 0 => 'Angola', 1 => 'Angola', 2 => 'AO', 3 => 'AGO', 4 => '024'],
                [ 0 => 'Anguilla', 1 => 'Anguilla', 2 => 'AI', 3 => 'AIA', 4 => '660'],
                [ 0 => 'Antarctica', 1 => 'Antarctica', 2 => 'AQ', 3 => 'ATA', 4 => '010'],
                [ 0 => 'Antigua and Barbuda', 1 => 'Antigua and Barbuda', 2 => 'AG', 3 => 'ATG', 4 => '028'],
                [ 0 => 'Argentina', 1 => 'Argentina', 2 => 'AR', 3 => 'ARG', 4 => '032'],
                [ 0 => 'Armenia', 1 => 'Հայաստան', 2 => 'AM', 3 => 'ARM', 4 => '051'],
                [ 0 => 'Aruba', 1 => 'Aruba', 2 => 'AW', 3 => 'ABW', 4 => '533'],
                [ 0 => 'Australia', 1 => 'Australia', 2 => 'AU', 3 => 'AUS', 4 => '036'],
                [ 0 => 'Austria', 1 => 'Österreich', 2 => 'AT', 3 => 'AUT', 4 => '040'],
                [ 0 => 'Azerbaijan', 1 => 'Azərbaycan', 2 => 'AZ', 3 => 'AZE', 4 => '031'],
                [ 0 => 'Bahamas', 1 => 'Bahamas', 2 => 'BS', 3 => 'BHS', 4 => '044'],
                [ 0 => 'Bahrain', 1 => '‏البحرين', 2 => 'BH', 3 => 'BHR', 4 => '048'],
                [ 0 => 'Bangladesh', 1 => 'Bangladesh', 2 => 'BD', 3 => 'BGD', 4 => '050'],
                [ 0 => 'Barbados', 1 => 'Barbados', 2 => 'BB', 3 => 'BRB', 4 => '052'],
                [ 0 => 'Belarus', 1 => 'Белару́сь', 2 => 'BY', 3 => 'BLR', 4 => '112'],
                [ 0 => 'Belgium', 1 => 'België', 2 => 'BE', 3 => 'BEL', 4 => '056'],
                [ 0 => 'Belize', 1 => 'Belize', 2 => 'BZ', 3 => 'BLZ', 4 => '084'],
                [ 0 => 'Benin', 1 => 'Bénin', 2 => 'BJ', 3 => 'BEN', 4 => '204'],
                [ 0 => 'Bermuda', 1 => 'Bermuda', 2 => 'BM', 3 => 'BMU', 4 => '060'],
                [ 0 => 'Bhutan', 1 => 'ʼbrug-yul', 2 => 'BT', 3 => 'BTN', 4 => '064'],
                [ 0 => 'Bolivia (Plurinational State of)', 1 => 'Bolivia', 2 => 'BO', 3 => 'BOL', 4 => '068'],
                [ 0 => 'Bonaire, Sint Eustatius and Saba', 1 => 'Bonaire', 2 => 'BQ', 3 => 'BES', 4 => '535'],
                [ 0 => 'Bosnia and Herzegovina', 1 => 'Bosna i Hercegovina', 2 => 'BA', 3 => 'BIH', 4 => '070'],
                [ 0 => 'Botswana', 1 => 'Botswana', 2 => 'BW', 3 => 'BWA', 4 => '072'],
                [ 0 => 'Bouvet Island', 1 => 'Bouvetøya', 2 => 'BV', 3 => 'BVT', 4 => '074'],
                [ 0 => 'Brazil', 1 => 'Brasil', 2 => 'BR', 3 => 'BRA', 4 => '076'],
                [ 0 => 'British Indian Ocean Territory', 1 => 'British Indian Ocean Territory', 2 => 'IO', 3 => 'IOT', 4 => '086'],
                [ 0 => 'United States Minor Outlying Islands', 1 => 'United States Minor Outlying Islands', 2 => 'UM', 3 => 'UMI', 4 => '581'],
                [ 0 => 'Virgin Islands (British)', 1 => 'British Virgin Islands', 2 => 'VG', 3 => 'VGB', 4 => '092'],
                [ 0 => 'Virgin Islands (U.S.)', 1 => 'Virgin Islands of the United States', 2 => 'VI', 3 => 'VIR', 4 => '850'],
                [ 0 => 'Brunei Darussalam', 1 => 'Negara Brunei Darussalam', 2 => 'BN', 3 => 'BRN', 4 => '096'],
                [ 0 => 'Bulgaria', 1 => 'България', 2 => 'BG', 3 => 'BGR', 4 => '100'],
                [ 0 => 'Burkina Faso', 1 => 'Burkina Faso', 2 => 'BF', 3 => 'BFA', 4 => '854'],
                [ 0 => 'Burundi', 1 => 'Burundi', 2 => 'BI', 3 => 'BDI', 4 => '108'],
                [ 0 => 'Cambodia', 1 => 'Kâmpŭchéa', 2 => 'KH', 3 => 'KHM', 4 => '116'],
                [ 0 => 'Cameroon', 1 => 'Cameroon', 2 => 'CM', 3 => 'CMR', 4 => '120'],
                [ 0 => 'Canada', 1 => 'Canada', 2 => 'CA', 3 => 'CAN', 4 => '124'],
                [ 0 => 'Cabo Verde', 1 => 'Cabo Verde', 2 => 'CV', 3 => 'CPV', 4 => '132'],
                [ 0 => 'Cayman Islands', 1 => 'Cayman Islands', 2 => 'KY', 3 => 'CYM', 4 => '136'],
                [ 0 => 'Central African Republic', 1 => 'Ködörösêse tî Bêafrîka', 2 => 'CF', 3 => 'CAF', 4 => '140'],
                [ 0 => 'Chad', 1 => 'Tchad', 2 => 'TD', 3 => 'TCD', 4 => '148'],
                [ 0 => 'Chile', 1 => 'Chile', 2 => 'CL', 3 => 'CHL', 4 => '152'],
                [ 0 => 'China', 1 => '中国', 2 => 'CN', 3 => 'CHN', 4 => '156'],
                [ 0 => 'Christmas Island', 1 => 'Christmas Island', 2 => 'CX', 3 => 'CXR', 4 => '162'],
                [ 0 => 'Cocos (Keeling) Islands', 1 => 'Cocos (Keeling) Islands', 2 => 'CC', 3 => 'CCK', 4 => '166'],
                [ 0 => 'Colombia', 1 => 'Colombia', 2 => 'CO', 3 => 'COL', 4 => '170'],
                [ 0 => 'Comoros', 1 => 'Komori', 2 => 'KM', 3 => 'COM', 4 => '174'],
                [ 0 => 'Congo', 1 => 'République du Congo', 2 => 'CG', 3 => 'COG', 4 => '178'],
                [ 0 => 'Congo (Democratic Republic of the)', 1 => 'République démocratique du Congo', 2 => 'CD', 3 => 'COD', 4 => '180'],
                [ 0 => 'Cook Islands', 1 => 'Cook Islands', 2 => 'CK', 3 => 'COK', 4 => '184'],
                [ 0 => 'Costa Rica', 1 => 'Costa Rica', 2 => 'CR', 3 => 'CRI', 4 => '188'],
                [ 0 => 'Croatia', 1 => 'Hrvatska', 2 => 'HR', 3 => 'HRV', 4 => '191'],
                [ 0 => 'Cuba', 1 => 'Cuba', 2 => 'CU', 3 => 'CUB', 4 => '192'],
                [ 0 => 'Curaçao', 1 => 'Curaçao', 2 => 'CW', 3 => 'CUW', 4 => '531'],
                [ 0 => 'Cyprus', 1 => 'Κύπρος', 2 => 'CY', 3 => 'CYP', 4 => '196'],
                [ 0 => 'Czech Republic', 1 => 'Česká republika', 2 => 'CZ', 3 => 'CZE', 4 => '203'],
                [ 0 => 'Denmark', 1 => 'Danmark', 2 => 'DK', 3 => 'DNK', 4 => '208'],
                [ 0 => 'Djibouti', 1 => 'Djibouti', 2 => 'DJ', 3 => 'DJI', 4 => '262'],
                [ 0 => 'Dominica', 1 => 'Dominica', 2 => 'DM', 3 => 'DMA', 4 => '212'],
                [ 0 => 'Dominican Republic', 1 => 'República Dominicana', 2 => 'DO', 3 => 'DOM', 4 => '214'],
                [ 0 => 'Ecuador', 1 => 'Ecuador', 2 => 'EC', 3 => 'ECU', 4 => '218'],
                [ 0 => 'Egypt', 1 => 'مصر‎', 2 => 'EG', 3 => 'EGY', 4 => '818'],
                [ 0 => 'El Salvador', 1 => 'El Salvador', 2 => 'SV', 3 => 'SLV', 4 => '222'],
                [ 0 => 'Equatorial Guinea', 1 => 'Guinea Ecuatorial', 2 => 'GQ', 3 => 'GNQ', 4 => '226'],
                [ 0 => 'Eritrea', 1 => 'ኤርትራ', 2 => 'ER', 3 => 'ERI', 4 => '232'],
                [ 0 => 'Estonia', 1 => 'Eesti', 2 => 'EE', 3 => 'EST', 4 => '233'],
                [ 0 => 'Ethiopia', 1 => 'ኢትዮጵያ', 2 => 'ET', 3 => 'ETH', 4 => '231'],
                [ 0 => 'Falkland Islands (Malvinas)', 1 => 'Falkland Islands', 2 => 'FK', 3 => 'FLK', 4 => '238'],
                [ 0 => 'Faroe Islands', 1 => 'Føroyar', 2 => 'FO', 3 => 'FRO', 4 => '234'],
                [ 0 => 'Fiji', 1 => 'Fiji', 2 => 'FJ', 3 => 'FJI', 4 => '242'],
                [ 0 => 'Finland', 1 => 'Suomi', 2 => 'FI', 3 => 'FIN', 4 => '246'],
                [ 0 => 'France', 1 => 'France', 2 => 'FR', 3 => 'FRA', 4 => '250'],
                [ 0 => 'French Guiana', 1 => 'Guyane française', 2 => 'GF', 3 => 'GUF', 4 => '254'],
                [ 0 => 'French Polynesia', 1 => 'Polynésie française', 2 => 'PF', 3 => 'PYF', 4 => '258'],
                [ 0 => 'French Southern Territories', 1 => 'Territoire des Terres australes et antarctiques françaises', 2 => 'TF', 3 => 'ATF', 4 => '260'],
                [ 0 => 'Gabon', 1 => 'Gabon', 2 => 'GA', 3 => 'GAB', 4 => '266'],
                [ 0 => 'Gambia', 1 => 'Gambia', 2 => 'GM', 3 => 'GMB', 4 => '270'],
                [ 0 => 'Georgia', 1 => 'საქართველო', 2 => 'GE', 3 => 'GEO', 4 => '268'],
                [ 0 => 'Germany', 1 => 'Deutschland', 2 => 'DE', 3 => 'DEU', 4 => '276'],
                [ 0 => 'Ghana', 1 => 'Ghana', 2 => 'GH', 3 => 'GHA', 4 => '288'],
                [ 0 => 'Gibraltar', 1 => 'Gibraltar', 2 => 'GI', 3 => 'GIB', 4 => '292'],
                [ 0 => 'Greece', 1 => 'Ελλάδα', 2 => 'GR', 3 => 'GRC', 4 => '300'],
                [ 0 => 'Greenland', 1 => 'Kalaallit Nunaat', 2 => 'GL', 3 => 'GRL', 4 => '304'],
                [ 0 => 'Grenada', 1 => 'Grenada', 2 => 'GD', 3 => 'GRD', 4 => '308'],
                [ 0 => 'Guadeloupe', 1 => 'Guadeloupe', 2 => 'GP', 3 => 'GLP', 4 => '312'],
                [ 0 => 'Guam', 1 => 'Guam', 2 => 'GU', 3 => 'GUM', 4 => '316'],
                [ 0 => 'Guatemala', 1 => 'Guatemala', 2 => 'GT', 3 => 'GTM', 4 => '320'],
                [ 0 => 'Guernsey', 1 => 'Guernsey', 2 => 'GG', 3 => 'GGY', 4 => '831'],
                [ 0 => 'Guinea', 1 => 'Guinée', 2 => 'GN', 3 => 'GIN', 4 => '324'],
                [ 0 => 'Guinea-Bissau', 1 => 'Guiné-Bissau', 2 => 'GW', 3 => 'GNB', 4 => '624'],
                [ 0 => 'Guyana', 1 => 'Guyana', 2 => 'GY', 3 => 'GUY', 4 => '328'],
                [ 0 => 'Haiti', 1 => 'Haïti', 2 => 'HT', 3 => 'HTI', 4 => '332'],
                [ 0 => 'Heard Island and McDonald Islands', 1 => 'Heard Island and McDonald Islands', 2 => 'HM', 3 => 'HMD', 4 => '334'],
                [ 0 => 'Holy See', 1 => 'Sancta Sedes', 2 => 'VA', 3 => 'VAT', 4 => '336'],
                [ 0 => 'Honduras', 1 => 'Honduras', 2 => 'HN', 3 => 'HND', 4 => '340'],
                [ 0 => 'Hong Kong', 1 => '香港', 2 => 'HK', 3 => 'HKG', 4 => '344'],
                [ 0 => 'Hungary', 1 => 'Magyarország', 2 => 'HU', 3 => 'HUN', 4 => '348'],
                [ 0 => 'Iceland', 1 => 'Ísland', 2 => 'IS', 3 => 'ISL', 4 => '352'],
                [ 0 => 'India', 1 => 'भारत', 2 => 'IN', 3 => 'IND', 4 => '356'],
                [ 0 => 'Indonesia', 1 => 'Indonesia', 2 => 'ID', 3 => 'IDN', 4 => '360'],
                [ 0 => 'Côte d\'Ivoire', 1 => 'Côte d\'Ivoire', 2 => 'CI', 3 => 'CIV', 4 => '384'],
                [ 0 => 'Iran (Islamic Republic of)', 1 => 'ایران', 2 => 'IR', 3 => 'IRN', 4 => '364'],
                [ 0 => 'Iraq', 1 => 'العراق', 2 => 'IQ', 3 => 'IRQ', 4 => '368'],
                [ 0 => 'Ireland', 1 => 'Éire', 2 => 'IE', 3 => 'IRL', 4 => '372'],
                [ 0 => 'Isle of Man', 1 => 'Isle of Man', 2 => 'IM', 3 => 'IMN', 4 => '833'],
                [ 0 => 'Israel', 1 => 'יִשְׂרָאֵל', 2 => 'IL', 3 => 'ISR', 4 => '376'],
                [ 0 => 'Italy', 1 => 'Italia', 2 => 'IT', 3 => 'ITA', 4 => '380'],
                [ 0 => 'Jamaica', 1 => 'Jamaica', 2 => 'JM', 3 => 'JAM', 4 => '388'],
                [ 0 => 'Japan', 1 => '日本', 2 => 'JP', 3 => 'JPN', 4 => '392'],
                [ 0 => 'Jersey', 1 => 'Jersey', 2 => 'JE', 3 => 'JEY', 4 => '832'],
                [ 0 => 'Jordan', 1 => 'الأردن', 2 => 'JO', 3 => 'JOR', 4 => '400'],
                [ 0 => 'Kazakhstan', 1 => 'Қазақстан', 2 => 'KZ', 3 => 'KAZ', 4 => '398'],
                [ 0 => 'Kenya', 1 => 'Kenya', 2 => 'KE', 3 => 'KEN', 4 => '404'],
                [ 0 => 'Kiribati', 1 => 'Kiribati', 2 => 'KI', 3 => 'KIR', 4 => '296'],
                [ 0 => 'Kuwait', 1 => 'الكويت', 2 => 'KW', 3 => 'KWT', 4 => '414'],
                [ 0 => 'Kyrgyzstan', 1 => 'Кыргызстан', 2 => 'KG', 3 => 'KGZ', 4 => '417'],
                [ 0 => 'Lao People\'s Democratic Republic', 1 => 'ສປປລາວ', 2 => 'LA', 3 => 'LAO', 4 => '418'],
                [ 0 => 'Latvia', 1 => 'Latvija', 2 => 'LV', 3 => 'LVA', 4 => '428'],
                [ 0 => 'Lebanon', 1 => 'لبنان', 2 => 'LB', 3 => 'LBN', 4 => '422'],
                [ 0 => 'Lesotho', 1 => 'Lesotho', 2 => 'LS', 3 => 'LSO', 4 => '426'],
                [ 0 => 'Liberia', 1 => 'Liberia', 2 => 'LR', 3 => 'LBR', 4 => '430'],
                [ 0 => 'Libya', 1 => '‏ليبيا', 2 => 'LY', 3 => 'LBY', 4 => '434'],
                [ 0 => 'Liechtenstein', 1 => 'Liechtenstein', 2 => 'LI', 3 => 'LIE', 4 => '438'],
                [ 0 => 'Lithuania', 1 => 'Lietuva', 2 => 'LT', 3 => 'LTU', 4 => '440'],
                [ 0 => 'Luxembourg', 1 => 'Luxembourg', 2 => 'LU', 3 => 'LUX', 4 => '442'],
                [ 0 => 'Macao', 1 => '澳門', 2 => 'MO', 3 => 'MAC', 4 => '446'],
                [ 0 => 'Macedonia (the former Yugoslav Republic of)', 1 => 'Македонија', 2 => 'MK', 3 => 'MKD', 4 => '807'],
                [ 0 => 'Madagascar', 1 => 'Madagasikara', 2 => 'MG', 3 => 'MDG', 4 => '450'],
                [ 0 => 'Malawi', 1 => 'Malawi', 2 => 'MW', 3 => 'MWI', 4 => '454'],
                [ 0 => 'Malaysia', 1 => 'Malaysia', 2 => 'MY', 3 => 'MYS', 4 => '458'],
                [ 0 => 'Maldives', 1 => 'Maldives', 2 => 'MV', 3 => 'MDV', 4 => '462'],
                [ 0 => 'Mali', 1 => 'Mali', 2 => 'ML', 3 => 'MLI', 4 => '466'],
                [ 0 => 'Malta', 1 => 'Malta', 2 => 'MT', 3 => 'MLT', 4 => '470'],
                [ 0 => 'Marshall Islands', 1 => 'M̧ajeļ', 2 => 'MH', 3 => 'MHL', 4 => '584'],
                [ 0 => 'Martinique', 1 => 'Martinique', 2 => 'MQ', 3 => 'MTQ', 4 => '474'],
                [ 0 => 'Mauritania', 1 => 'موريتانيا', 2 => 'MR', 3 => 'MRT', 4 => '478'],
                [ 0 => 'Mauritius', 1 => 'Maurice', 2 => 'MU', 3 => 'MUS', 4 => '480'],
                [ 0 => 'Mayotte', 1 => 'Mayotte', 2 => 'YT', 3 => 'MYT', 4 => '175'],
                [ 0 => 'Mexico', 1 => 'México', 2 => 'MX', 3 => 'MEX', 4 => '484'],
                [ 0 => 'Micronesia (Federated States of)', 1 => 'Micronesia', 2 => 'FM', 3 => 'FSM', 4 => '583'],
                [ 0 => 'Moldova (Republic of)', 1 => 'Moldova', 2 => 'MD', 3 => 'MDA', 4 => '498'],
                [ 0 => 'Monaco', 1 => 'Monaco', 2 => 'MC', 3 => 'MCO', 4 => '492'],
                [ 0 => 'Mongolia', 1 => 'Монгол улс', 2 => 'MN', 3 => 'MNG', 4 => '496'],
                [ 0 => 'Montenegro', 1 => 'Црна Гора', 2 => 'ME', 3 => 'MNE', 4 => '499'],
                [ 0 => 'Montserrat', 1 => 'Montserrat', 2 => 'MS', 3 => 'MSR', 4 => '500'],
                [ 0 => 'Morocco', 1 => 'المغرب', 2 => 'MA', 3 => 'MAR', 4 => '504'],
                [ 0 => 'Mozambique', 1 => 'Moçambique', 2 => 'MZ', 3 => 'MOZ', 4 => '508'],
                [ 0 => 'Myanmar', 1 => 'Myanma', 2 => 'MM', 3 => 'MMR', 4 => '104'],
                [ 0 => 'Namibia', 1 => 'Namibia', 2 => 'NA', 3 => 'NAM', 4 => '516'],
                [ 0 => 'Nauru', 1 => 'Nauru', 2 => 'NR', 3 => 'NRU', 4 => '520'],
                [ 0 => 'Nepal', 1 => 'नेपाल', 2 => 'NP', 3 => 'NPL', 4 => '524'],
                [ 0 => 'Netherlands', 1 => 'Nederland', 2 => 'NL', 3 => 'NLD', 4 => '528'],
                [ 0 => 'New Caledonia', 1 => 'Nouvelle-Calédonie', 2 => 'NC', 3 => 'NCL', 4 => '540'],
                [ 0 => 'New Zealand', 1 => 'New Zealand', 2 => 'NZ', 3 => 'NZL', 4 => '554'],
                [ 0 => 'Nicaragua', 1 => 'Nicaragua', 2 => 'NI', 3 => 'NIC', 4 => '558'],
                [ 0 => 'Niger', 1 => 'Niger', 2 => 'NE', 3 => 'NER', 4 => '562'],
                [ 0 => 'Nigeria', 1 => 'Nigeria', 2 => 'NG', 3 => 'NGA', 4 => '566'],
                [ 0 => 'Niue', 1 => 'Niuē', 2 => 'NU', 3 => 'NIU', 4 => '570'],
                [ 0 => 'Norfolk Island', 1 => 'Norfolk Island', 2 => 'NF', 3 => 'NFK', 4 => '574'],
                [ 0 => 'Korea (Democratic People\'s Republic of)', 1 => '북한', 2 => 'KP', 3 => 'PRK', 4 => '408'],
                [ 0 => 'Northern Mariana Islands', 1 => 'Northern Mariana Islands', 2 => 'MP', 3 => 'MNP', 4 => '580'],
                [ 0 => 'Norway', 1 => 'Norge', 2 => 'NO', 3 => 'NOR', 4 => '578'],
                [ 0 => 'Oman', 1 => 'عمان', 2 => 'OM', 3 => 'OMN', 4 => '512'],
                [ 0 => 'Pakistan', 1 => 'Pakistan', 2 => 'PK', 3 => 'PAK', 4 => '586'],
                [ 0 => 'Palau', 1 => 'Palau', 2 => 'PW', 3 => 'PLW', 4 => '585'],
                [ 0 => 'Palestine, State of', 1 => 'فلسطين', 2 => 'PS', 3 => 'PSE', 4 => '275'],
                [ 0 => 'Panama', 1 => 'Panamá', 2 => 'PA', 3 => 'PAN', 4 => '591'],
                [ 0 => 'Papua New Guinea', 1 => 'Papua Niugini', 2 => 'PG', 3 => 'PNG', 4 => '598'],
                [ 0 => 'Paraguay', 1 => 'Paraguay', 2 => 'PY', 3 => 'PRY', 4 => '600'],
                [ 0 => 'Peru', 1 => 'Perú', 2 => 'PE', 3 => 'PER', 4 => '604'],
                [ 0 => 'Philippines', 1 => 'Pilipinas', 2 => 'PH', 3 => 'PHL', 4 => '608'],
                [ 0 => 'Pitcairn', 1 => 'Pitcairn Islands', 2 => 'PN', 3 => 'PCN', 4 => '612'],
                [ 0 => 'Poland', 1 => 'Polska', 2 => 'PL', 3 => 'POL', 4 => '616'],
                [ 0 => 'Portugal', 1 => 'Portugal', 2 => 'PT', 3 => 'PRT', 4 => '620'],
                [ 0 => 'Puerto Rico', 1 => 'Puerto Rico', 2 => 'PR', 3 => 'PRI', 4 => '630'],
                [ 0 => 'Qatar', 1 => 'قطر', 2 => 'QA', 3 => 'QAT', 4 => '634'],
                [ 0 => 'Republic of Kosovo', 1 => 'Republika e Kosovës', 2 => 'XK', 3 => 'KOS', 4 => ''],
                [ 0 => 'Réunion', 1 => 'La Réunion', 2 => 'RE', 3 => 'REU', 4 => '638'],
                [ 0 => 'Romania', 1 => 'România', 2 => 'RO', 3 => 'ROU', 4 => '642'],
                [ 0 => 'Russian Federation', 1 => 'Россия', 2 => 'RU', 3 => 'RUS', 4 => '643'],
                [ 0 => 'Rwanda', 1 => 'Rwanda', 2 => 'RW', 3 => 'RWA', 4 => '646'],
                [ 0 => 'Saint Barthélemy', 1 => 'Saint-Barthélemy', 2 => 'BL', 3 => 'BLM', 4 => '652'],
                [ 0 => 'Saint Helena, Ascension and Tristan da Cunha', 1 => 'Saint Helena', 2 => 'SH', 3 => 'SHN', 4 => '654'],
                [ 0 => 'Saint Kitts and Nevis', 1 => 'Saint Kitts and Nevis', 2 => 'KN', 3 => 'KNA', 4 => '659'],
                [ 0 => 'Saint Lucia', 1 => 'Saint Lucia', 2 => 'LC', 3 => 'LCA', 4 => '662'],
                [ 0 => 'Saint Martin (French part)', 1 => 'Saint-Martin', 2 => 'MF', 3 => 'MAF', 4 => '663'],
                [ 0 => 'Saint Pierre and Miquelon', 1 => 'Saint-Pierre-et-Miquelon', 2 => 'PM', 3 => 'SPM', 4 => '666'],
                [ 0 => 'Saint Vincent and the Grenadines', 1 => 'Saint Vincent and the Grenadines', 2 => 'VC', 3 => 'VCT', 4 => '670'],
                [ 0 => 'Samoa', 1 => 'Samoa', 2 => 'WS', 3 => 'WSM', 4 => '882'],
                [ 0 => 'San Marino', 1 => 'San Marino', 2 => 'SM', 3 => 'SMR', 4 => '674'],
                [ 0 => 'Sao Tome and Principe', 1 => 'São Tomé e Príncipe', 2 => 'ST', 3 => 'STP', 4 => '678'],
                [ 0 => 'Saudi Arabia', 1 => 'العربية السعودية', 2 => 'SA', 3 => 'SAU', 4 => '682'],
                [ 0 => 'Senegal', 1 => 'Sénégal', 2 => 'SN', 3 => 'SEN', 4 => '686'],
                [ 0 => 'Serbia', 1 => 'Србија', 2 => 'RS', 3 => 'SRB', 4 => '688'],
                [ 0 => 'Seychelles', 1 => 'Seychelles', 2 => 'SC', 3 => 'SYC', 4 => '690'],
                [ 0 => 'Sierra Leone', 1 => 'Sierra Leone', 2 => 'SL', 3 => 'SLE', 4 => '694'],
                [ 0 => 'Singapore', 1 => 'Singapore', 2 => 'SG', 3 => 'SGP', 4 => '702'],
                [ 0 => 'Sint Maarten (Dutch part)', 1 => 'Sint Maarten', 2 => 'SX', 3 => 'SXM', 4 => '534'],
                [ 0 => 'Slovakia', 1 => 'Slovensko', 2 => 'SK', 3 => 'SVK', 4 => '703'],
                [ 0 => 'Slovenia', 1 => 'Slovenija', 2 => 'SI', 3 => 'SVN', 4 => '705'],
                [ 0 => 'Solomon Islands', 1 => 'Solomon Islands', 2 => 'SB', 3 => 'SLB', 4 => '090'],
                [ 0 => 'Somalia', 1 => 'Soomaaliya', 2 => 'SO', 3 => 'SOM', 4 => '706'],
                [ 0 => 'South Africa', 1 => 'South Africa', 2 => 'ZA', 3 => 'ZAF', 4 => '710'],
                [ 0 => 'South Georgia and the South Sandwich Islands', 1 => 'South Georgia', 2 => 'GS', 3 => 'SGS', 4 => '239'],
                [ 0 => 'Korea (Republic of)', 1 => '대한민국', 2 => 'KR', 3 => 'KOR', 4 => '410'],
                [ 0 => 'South Sudan', 1 => 'South Sudan', 2 => 'SS', 3 => 'SSD', 4 => '728'],
                [ 0 => 'Spain', 1 => 'España', 2 => 'ES', 3 => 'ESP', 4 => '724'],
                [ 0 => 'Sri Lanka', 1 => 'śrī laṃkāva', 2 => 'LK', 3 => 'LKA', 4 => '144'],
                [ 0 => 'Sudan', 1 => 'السودان', 2 => 'SD', 3 => 'SDN', 4 => '729'],
                [ 0 => 'Suriname', 1 => 'Suriname', 2 => 'SR', 3 => 'SUR', 4 => '740'],
                [ 0 => 'Svalbard and Jan Mayen', 1 => 'Svalbard og Jan Mayen', 2 => 'SJ', 3 => 'SJM', 4 => '744'],
                [ 0 => 'Swaziland', 1 => 'Swaziland', 2 => 'SZ', 3 => 'SWZ', 4 => '748'],
                [ 0 => 'Sweden', 1 => 'Sverige', 2 => 'SE', 3 => 'SWE', 4 => '752'],
                [ 0 => 'Switzerland', 1 => 'Schweiz', 2 => 'CH', 3 => 'CHE', 4 => '756'],
                [ 0 => 'Syrian Arab Republic', 1 => 'سوريا', 2 => 'SY', 3 => 'SYR', 4 => '760'],
                [ 0 => 'Taiwan', 1 => '臺灣', 2 => 'TW', 3 => 'TWN', 4 => '158'],
                [ 0 => 'Tajikistan', 1 => 'Тоҷикистон', 2 => 'TJ', 3 => 'TJK', 4 => '762'],
                [ 0 => 'Tanzania, United Republic of', 1 => 'Tanzania', 2 => 'TZ', 3 => 'TZA', 4 => '834'],
                [ 0 => 'Thailand', 1 => 'ประเทศไทย', 2 => 'TH', 3 => 'THA', 4 => '764'],
                [ 0 => 'Timor-Leste', 1 => 'Timor-Leste', 2 => 'TL', 3 => 'TLS', 4 => '626'],
                [ 0 => 'Togo', 1 => 'Togo', 2 => 'TG', 3 => 'TGO', 4 => '768'],
                [ 0 => 'Tokelau', 1 => 'Tokelau', 2 => 'TK', 3 => 'TKL', 4 => '772'],
                [ 0 => 'Tonga', 1 => 'Tonga', 2 => 'TO', 3 => 'TON', 4 => '776'],
                [ 0 => 'Trinidad and Tobago', 1 => 'Trinidad and Tobago', 2 => 'TT', 3 => 'TTO', 4 => '780'],
                [ 0 => 'Tunisia', 1 => 'تونس', 2 => 'TN', 3 => 'TUN', 4 => '788'],
                [ 0 => 'Turkey', 1 => 'Türkiye', 2 => 'TR', 3 => 'TUR', 4 => '792'],
                [ 0 => 'Turkmenistan', 1 => 'Türkmenistan', 2 => 'TM', 3 => 'TKM', 4 => '795'],
                [ 0 => 'Turks and Caicos Islands', 1 => 'Turks and Caicos Islands', 2 => 'TC', 3 => 'TCA', 4 => '796'],
                [ 0 => 'Tuvalu', 1 => 'Tuvalu', 2 => 'TV', 3 => 'TUV', 4 => '798'],
                [ 0 => 'Uganda', 1 => 'Uganda', 2 => 'UG', 3 => 'UGA', 4 => '800'],
                [ 0 => 'Ukraine', 1 => 'Україна', 2 => 'UA', 3 => 'UKR', 4 => '804'],
                [ 0 => 'United Arab Emirates', 1 => 'دولة الإمارات العربية المتحدة', 2 => 'AE', 3 => 'ARE', 4 => '784'],
                [ 0 => 'United Kingdom of Great Britain and Northern Ireland', 1 => 'United Kingdom', 2 => 'GB', 3 => 'GBR', 4 => '826'],
                [ 0 => 'United States of America', 1 => 'United States', 2 => 'US', 3 => 'USA', 4 => '840'],
                [ 0 => 'Uruguay', 1 => 'Uruguay', 2 => 'UY', 3 => 'URY', 4 => '858'],
                [ 0 => 'Uzbekistan', 1 => 'O‘zbekiston', 2 => 'UZ', 3 => 'UZB', 4 => '860'],
                [ 0 => 'Vanuatu', 1 => 'Vanuatu', 2 => 'VU', 3 => 'VUT', 4 => '548'],
                [ 0 => 'Venezuela (Bolivarian Republic of)', 1 => 'Venezuela', 2 => 'VE', 3 => 'VEN', 4 => '862'],
                [ 0 => 'Viet Nam', 1 => 'Việt Nam', 2 => 'VN', 3 => 'VNM', 4 => '704'],
                [ 0 => 'Wallis and Futuna', 1 => 'Wallis et Futuna', 2 => 'WF', 3 => 'WLF', 4 => '876'],
                [ 0 => 'Western Sahara', 1 => 'الصحراء الغربية', 2 => 'EH', 3 => 'ESH', 4 => '732'],
                [ 0 => 'Yemen', 1 => 'اليَمَن', 2 => 'YE', 3 => 'YEM', 4 => '887'],
                [ 0 => 'Zambia', 1 => 'Zambia', 2 => 'ZM', 3 => 'ZMB', 4 => '894'],
                [ 0 => 'Zimbabwe', 1 => 'Zimbabwe', 2 => 'ZW', 3 => 'ZWE', 4 => '716']
            ];

        /********************************************************************************
         * GET METHOD
         *
         * @param int $codeType
         * @param string $code
         * @param bool $useAPI Defaults to FALSE
         * @return array
         ********************************************************************************/

            public static function get(int $codeType, string $code, bool $useAPI = FALSE): array
            {
                // FORMAT CODE | VALIDATE PASSED CODE TYPE

                    $code = strtoupper(trim($code));

                    if (in_array($codeType, self::CODE_TYPES))
                    {
                        // LOOP THROUGH COUNTRIES AND FIND A MATCH

                            foreach (self::getAll($useAPI) as $country)
                            {
                                if ($code === strtoupper($country[$codeType]))
                                {
                                    $selectedCountry['name']       = $country[self::CODE_TYPE_COUNTRY_NAME];
                                    $selectedCountry['nativeName'] = $country[self::CODE_TYPE_NATIVE_NAME];
                                    $selectedCountry['2letter']    = $country[self::CODE_TYPE_2_LETTER];
                                    $selectedCountry['3letter']    = $country[self::CODE_TYPE_3_LETTER];
                                    $selectedCountry['un']         = $country[self::CODE_TYPE_UN];
                                    break;
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