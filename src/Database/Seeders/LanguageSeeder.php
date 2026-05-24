<?php

namespace Molitor\Language\Database\Seeders;

use Illuminate\Database\Seeder;
use Molitor\Language\Models\Language;
use Molitor\Language\Repositories\LanguageRepositoryInterface;
use Molitor\User\Exceptions\PermissionException;
use Molitor\User\Services\AclManagementService;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            /** @var AclManagementService $aclService */
            $aclService = app(AclManagementService::class);
            $aclService->createPermission('language', 'Nyelvek kezelése', 'admin');
        } catch (PermissionException $e) {
            $this->command->error($e->getMessage());
        }

        $languages = [
            [
                'code' => 'ab',
                'name' => [
                    'en' => 'Abkhaz',
                    'ab' => 'аҧсуа',
                    'hu' => 'Abház',
                ],
            ],
            [
                'code' => 'aa',
                'name' => [
                    'en' => 'Afar',
                    'aa' => 'Afaraf',
                    'hu' => 'Afár',
                ],
            ],
            [
                'code' => 'af',
                'name' => [
                    'en' => 'Afrikaans',
                    'af' => 'Afrikaans',
                    'hu' => 'Afrikaans',
                ],
            ],
            [
                'code' => 'ak',
                'name' => [
                    'en' => 'Akan',
                    'ak' => 'Akan',
                    'hu' => 'Akan',
                ],
            ],
            [
                'code' => 'sq',
                'name' => [
                    'en' => 'Albanian',
                    'sq' => 'Shqip',
                    'hu' => 'Albán',
                ],
            ],
            [
                'code' => 'am',
                'name' => [
                    'en' => 'Amharic',
                    'am' => 'አማርኛ',
                    'hu' => 'Amhár',
                ],
            ],
            [
                'code' => 'ar',
                'name' => [
                    'en' => 'Arabic',
                    'ar' => 'العربية',
                    'hu' => 'Arab',
                ],
            ],
            [
                'code' => 'an',
                'name' => [
                    'en' => 'Aragonese',
                    'an' => 'Aragonés',
                    'hu' => 'Aragonai',
                ],
            ],
            [
                'code' => 'hy',
                'name' => [
                    'en' => 'Armenian',
                    'hy' => 'Հայերեն',
                    'hu' => 'Örmény',
                ],
            ],
            [
                'code' => 'as',
                'name' => [
                    'en' => 'Assamese',
                    'as' => 'অসমীয়া',
                    'hu' => 'Asszámi',
                ],
            ],
            [
                'code' => 'av',
                'name' => [
                    'en' => 'Avaric',
                    'av' => 'авар мацӀ, магӀарул мацӀ',
                    'hu' => 'Avár',
                ],
            ],
            [
                'code' => 'ae',
                'name' => [
                    'en' => 'Avestan',
                    'ae' => 'avesta',
                    'hu' => 'Aveszt',
                ],
            ],
            [
                'code' => 'ay',
                'name' => [
                    'en' => 'Aymara',
                    'ay' => 'aymar aru',
                    'hu' => 'Aymara',
                ],
            ],
            [
                'code' => 'az',
                'name' => [
                    'en' => 'Azerbaijani',
                    'az' => 'azərbaycan dili',
                    'hu' => 'Azerbajdzsáni',
                ],
            ],
            [
                'code' => 'bm',
                'name' => [
                    'en' => 'Bambara',
                    'bm' => 'bamanankan',
                    'hu' => 'Bambara',
                ],
            ],
            [
                'code' => 'ba',
                'name' => [
                    'en' => 'Bashkir',
                    'ba' => 'башҡорт теле',
                    'hu' => 'Baškír',
                ],
            ],
            [
                'code' => 'eu',
                'name' => [
                    'en' => 'Basque',
                    'eu' => 'euskara, euskera',
                    'hu' => 'Baszk',
                ],
            ],
            [
                'code' => 'be',
                'name' => [
                    'en' => 'Belarusian',
                    'be' => 'Беларуская',
                    'hu' => 'Belarusz',
                ],
            ],
            [
                'code' => 'bn',
                'name' => [
                    'en' => 'Bengali',
                    'bn' => 'বাংলা',
                    'hu' => 'Bengáli',
                ],
            ],
            [
                'code' => 'bh',
                'name' => [
                    'en' => 'Bihari',
                    'bh' => 'भोजपुरी',
                    'hu' => 'Bihari',
                ],
            ],
            [
                'code' => 'bi',
                'name' => [
                    'en' => 'Bislama',
                    'bi' => 'Bislama',
                    'hu' => 'Bislama',
                ],
            ],
            [
                'code' => 'bs',
                'name' => [
                    'en' => 'Bosnian',
                    'bs' => 'bosanski jezik',
                    'hu' => 'Bosnyák',
                ],
            ],
            [
                'code' => 'br',
                'name' => [
                    'en' => 'Breton',
                    'br' => 'brezhoneg',
                    'hu' => 'Breton',
                ],
            ],
            [
                'code' => 'bg',
                'name' => [
                    'en' => 'Bulgarian',
                    'bg' => 'български език',
                    'hu' => 'Bolgár',
                ],
            ],
            [
                'code' => 'my',
                'name' => [
                    'en' => 'Burmese',
                    'my' => 'ဗမာစာ',
                    'hu' => 'Birmai',
                ],
            ],
            [
                'code' => 'ca',
                'name' => [
                    'en' => 'Catalan; Valencian',
                    'ca' => 'Català',
                    'hu' => 'Katalán',
                ],
            ],
            [
                'code' => 'ch',
                'name' => [
                    'en' => 'Chamorro',
                    'ch' => 'Chamoru',
                    'hu' => 'Chamorro',
                ],
            ],
            [
                'code' => 'ce',
                'name' => [
                    'en' => 'Chechen',
                    'ce' => 'нохчийн мотт',
                    'hu' => 'Csecsen',
                ],
            ],
            [
                'code' => 'ny',
                'name' => [
                    'en' => 'Chichewa; Chewa; Nyanja',
                    'ny' => 'chiCheŵa, chinyanja',
                    'hu' => 'Csicseva',
                ],
            ],
            [
                'code' => 'zh',
                'name' => [
                    'en' => 'Chinese',
                    'zh' => '中文 (Zhōngwén), 汉语, 漢語',
                    'hu' => 'Kínai',
                ],
            ],
            [
                'code' => 'cv',
                'name' => [
                    'en' => 'Chuvash',
                    'cv' => 'чӑваш чӗлхи',
                    'hu' => 'Csuvás',
                ],
            ],
            [
                'code' => 'kw',
                'name' => [
                    'en' => 'Cornish',
                    'kw' => 'Kernewek',
                    'hu' => 'Kornvall',
                ],
            ],
            [
                'code' => 'co',
                'name' => [
                    'en' => 'Corsican',
                    'co' => 'corsu, lingua corsa',
                    'hu' => 'Korzikai',
                ],
            ],
            [
                'code' => 'cr',
                'name' => [
                    'en' => 'Cree',
                    'cr' => 'ᓀᐦᐃᔭᐍᐏᐣ',
                    'hu' => 'Kríj',
                ],
            ],
            [
                'code' => 'hr',
                'name' => [
                    'en' => 'Croatian',
                    'hr' => 'hrvatski',
                    'hu' => 'Horvát',
                ],
            ],
            [
                'code' => 'cs',
                'name' => [
                    'en' => 'Czech',
                    'cs' => 'česky, čeština',
                    'hu' => 'Cseh',
                ],
            ],
            [
                'code' => 'da',
                'name' => [
                    'en' => 'Danish',
                    'da' => 'dansk',
                    'hu' => 'Dán',
                ],
            ],
            [
                'code' => 'dv',
                'name' => [
                    'en' => 'Divehi; Dhivehi; Maldivian;',
                    'dv' => 'ދިވެހި',
                    'hu' => 'Divahi',
                ],
            ],
            [
                'code' => 'nl',
                'name' => [
                    'en' => 'Dutch',
                    'nl' => 'Nederlands, Vlaams',
                    'hu' => 'Holland',
                ],
            ],
            [
                'enabled' => true,
                'code' => 'en',
                'name' => [
                    'en' => 'English',
                    'hu' => 'Angol',
                ],
            ],
            [
                'code' => 'eo',
                'name' => [
                    'en' => 'Esperanto',
                    'eo' => 'Esperanto',
                    'hu' => 'Eszperantó',
                ],
            ],
            [
                'code' => 'et',
                'name' => [
                    'en' => 'Estonian',
                    'et' => 'eesti, eesti keel',
                    'hu' => 'Észt',
                ],
            ],
            [
                'code' => 'ee',
                'name' => [
                    'en' => 'Ewe',
                    'ee' => 'Eʋegbe',
                    'hu' => 'Eve',
                ],
            ],
            [
                'code' => 'fo',
                'name' => [
                    'en' => 'Faroese',
                    'fo' => 'føroyskt',
                    'hu' => 'Faroe-szigeti',
                ],
            ],
            [
                'code' => 'fj',
                'name' => [
                    'en' => 'Fijian',
                    'fj' => 'vosa Vakaviti',
                    'hu' => 'Fidzsi',
                ],
            ],
            [
                'code' => 'fi',
                'name' => [
                    'en' => 'Finnish',
                    'fi' => 'suomi, suomen kieli',
                    'hu' => 'Finn',
                ],
            ],
            [
                'code' => 'fr',
                'name' => [
                    'en' => 'French',
                    'fr' => 'français, langue française',
                    'hu' => 'Francia',
                ],
            ],
            [
                'code' => 'ff',
                'name' => [
                    'en' => 'Fula; Fulah; Pulaar; Pular',
                    'ff' => 'Fulfulde, Pulaar, Pular',
                    'hu' => 'Fullani',
                ],
            ],
            [
                'code' => 'gl',
                'name' => [
                    'en' => 'Galician',
                    'gl' => 'Galego',
                    'hu' => 'Galíciai',
                ],
            ],
            [
                'code' => 'ka',
                'name' => [
                    'en' => 'Georgian',
                    'ka' => 'ქართული',
                    'hu' => 'Grúz',
                ],
            ],
            [
                'code' => 'de',
                'name' => [
                    'en' => 'German',
                    'de' => 'Deutsch',
                    'hu' => 'Német',
                ],
            ],
            [
                'code' => 'el',
                'name' => [
                    'en' => 'Greek, Modern',
                    'el' => 'Ελληνικά',
                    'hu' => 'Görög',
                ],
            ],
            [
                'code' => 'gn',
                'name' => [
                    'en' => 'Guaraní',
                    'gn' => 'Avañeẽ',
                    'hu' => 'Guarani',
                ],
            ],
            [
                'code' => 'gu',
                'name' => [
                    'en' => 'Gujarati',
                    'gu' => 'ગુજરાતી',
                    'hu' => 'Gujarati',
                ],
            ],
            [
                'code' => 'ht',
                'name' => [
                    'en' => 'Haitian; Haitian Creole',
                    'ht' => 'Kreyòl ayisyen',
                    'hu' => 'Haiti-kreol',
                ],
            ],
            [
                'code' => 'ha',
                'name' => [
                    'en' => 'Hausa',
                    'ha' => 'Hausa, هَوُسَ',
                    'hu' => 'Hausza',
                ],
            ],
            [
                'code' => 'he',
                'name' => [
                    'en' => 'Hebrew (modern)',
                    'he' => 'עברית',
                    'hu' => 'Héber',
                ],
            ],
            [
                'code' => 'hz',
                'name' => [
                    'en' => 'Herero',
                    'hz' => 'Otjiherero',
                    'hu' => 'Herero',
                ],
            ],
            [
                'code' => 'hi',
                'name' => [
                    'en' => 'Hindi',
                    'hi' => 'हिन्दी, हिंदी',
                    'hu' => 'Hindi',
                ],
            ],
            [
                'code' => 'ho',
                'name' => [
                    'en' => 'Hiri Motu',
                    'ho' => 'Hiri Motu',
                    'hu' => 'Hiri Motu',
                ],
            ],
            [
                'enabled' => true,
                'code' => 'hu',
                'name' => [
                    'hu' => 'Magyar',
                    'en' => 'Hungarian',
                ],
            ],
            [
                'code' => 'ia',
                'name' => [
                    'en' => 'Interlingua',
                    'ia' => 'Interlingua',
                    'hu' => 'Interlingua',
                ],
            ],
            [
                'code' => 'id',
                'name' => [
                    'en' => 'Indonesian',
                    'id' => 'Bahasa Indonesia',
                    'hu' => 'Indonéz',
                ],
            ],
            [
                'code' => 'ie',
                'name' => [
                    'en' => 'Interlingue',
                    'ie' => 'Originally called Occidental; then Interlingue after WWII',
                    'hu' => 'Interlingue',
                ],
            ],
            [
                'code' => 'ga',
                'name' => [
                    'en' => 'Irish',
                    'ga' => 'Gaeilge',
                    'hu' => 'Ír',
                ],
            ],
            [
                'code' => 'ig',
                'name' => [
                    'en' => 'Igbo',
                    'ig' => 'Asụsụ Igbo',
                    'hu' => 'Igbo',
                ],
            ],
            [
                'code' => 'ik',
                'name' => [
                    'en' => 'Inupiaq',
                    'ik' => 'Iñupiaq, Iñupiatun',
                    'hu' => 'Inupiaq',
                ],
            ],
            [
                'code' => 'io',
                'name' => [
                    'en' => 'Ido',
                    'io' => 'Ido',
                    'hu' => 'Ido',
                ],
            ],
            [
                'code' => 'is',
                'name' => [
                    'en' => 'Icelandic',
                    'is' => 'Íslenska',
                    'hu' => 'Izlandi',
                ],
            ],
            [
                'code' => 'it',
                'name' => [
                    'en' => 'Italian',
                    'it' => 'Italiano',
                    'hu' => 'Olasz',
                ],
            ],
            [
                'code' => 'iu',
                'name' => [
                    'en' => 'Inuktitut',
                    'iu' => 'ᐃᓄᒃᑎᑐᑦ',
                    'hu' => 'Inuktitut',
                ],
            ],
            [
                'code' => 'ja',
                'name' => [
                    'en' => 'Japanese',
                    'ja' => '日本語 (にほんご／にっぽんご)',
                    'hu' => 'Japán',
                ],
            ],
            [
                'code' => 'jv',
                'name' => [
                    'en' => 'Javanese',
                    'jv' => 'basa Jawa',
                    'hu' => 'Jávai',
                ],
            ],
            [
                'code' => 'kl',
                'name' => [
                    'en' => 'Kalaallisut, Greenlandic',
                    'kl' => 'kalaallisut, kalaallit oqaasii',
                    'hu' => 'Grönlandi',
                ],
            ],
            [
                'code' => 'kn',
                'name' => [
                    'en' => 'Kannada',
                    'kn' => 'ಕನ್ನಡ',
                    'hu' => 'Kannada',
                ],
            ],
            [
                'code' => 'kr',
                'name' => [
                    'en' => 'Kanuri',
                    'kr' => 'Kanuri',
                    'hu' => 'Kanuri',
                ],
            ],
            [
                'code' => 'ks',
                'name' => [
                    'en' => 'Kashmiri',
                    'ks' => 'कश्मीरी, كشميري‎',
                    'hu' => 'Kesmiri',
                ],
            ],
            [
                'code' => 'kk',
                'name' => [
                    'en' => 'Kazakh',
                    'kk' => 'Қазақ тілі',
                    'hu' => 'Kazah',
                ],
            ],
            [
                'code' => 'km',
                'name' => [
                    'en' => 'Khmer',
                    'km' => 'ភាសាខ្មែរ',
                    'hu' => 'Khmer',
                ],
            ],
            [
                'code' => 'ki',
                'name' => [
                    'en' => 'Kikuyu, Gikuyu',
                    'ki' => 'Gĩkũyũ',
                    'hu' => 'Kikuyu',
                ],
            ],
            [
                'code' => 'rw',
                'name' => [
                    'en' => 'Kinyarwanda',
                    'rw' => 'Ikinyarwanda',
                    'hu' => 'Ruandai',
                ],
            ],
            [
                'code' => 'ky',
                'name' => [
                    'en' => 'Kirghiz, Kyrgyz',
                    'ky' => 'кыргыз тили',
                    'hu' => 'Kirgiz',
                ],
            ],
            [
                'code' => 'kv',
                'name' => [
                    'en' => 'Komi',
                    'kv' => 'коми кыв',
                    'hu' => 'Komi',
                ],
            ],
            [
                'code' => 'kg',
                'name' => [
                    'en' => 'Kongo',
                    'kg' => 'KiKongo',
                    'hu' => 'Konga',
                ],
            ],
            [
                'code' => 'ko',
                'name' => [
                    'en' => 'Korean',
                    'ko' => '한국어 (韓國語), 조선말 (朝鮮語)',
                    'hu' => 'Koreai',
                ],
            ],
            [
                'code' => 'ku',
                'name' => [
                    'en' => 'Kurdish',
                    'ku' => 'Kurdî, كوردی‎',
                    'hu' => 'Kurd',
                ],
            ],
            [
                'code' => 'kj',
                'name' => [
                    'en' => 'Kwanyama, Kuanyama',
                    'kj' => 'Kuanyama',
                    'hu' => 'Kwanyama',
                ],
            ],
            [
                'code' => 'la',
                'name' => [
                    'en' => 'Latin',
                    'la' => 'latine, lingua latina',
                    'hu' => 'Latin',
                ],
            ],
            [
                'code' => 'lb',
                'name' => [
                    'en' => 'Luxembourgish, Letzeburgesch',
                    'lb' => 'Lëtzebuergesch',
                    'hu' => 'Luxemburgi',
                ],
            ],
            [
                'code' => 'lg',
                'name' => [
                    'en' => 'Luganda',
                    'lg' => 'Luganda',
                    'hu' => 'Luganda',
                ],
            ],
            [
                'code' => 'li',
                'name' => [
                    'en' => 'Limburgish, Limburgan, Limburger',
                    'li' => 'Limburgs',
                    'hu' => 'Limburgi',
                ],
            ],
            [
                'code' => 'ln',
                'name' => [
                    'en' => 'Lingala',
                    'ln' => 'Lingála',
                    'hu' => 'Lingala',
                ],
            ],
            [
                'code' => 'lo',
                'name' => [
                    'en' => 'Lao',
                    'lo' => 'ພາສາລາວ',
                    'hu' => 'Lao',
                ],
            ],
            [
                'code' => 'lt',
                'name' => [
                    'en' => 'Lithuanian',
                    'lt' => 'lietuvių kalba',
                    'hu' => 'Litván',
                ],
            ],
            [
                'code' => 'lu',
                'name' => [
                    'en' => 'Luba-Katanga',
                    'lu' => 'Luba-Katanga',
                    'hu' => 'Luba-Katanga',
                ],
            ],
            [
                'code' => 'lv',
                'name' => [
                    'en' => 'Latvian',
                    'lv' => 'latviešu valoda',
                    'hu' => 'Lett',
                ],
            ],
            [
                'code' => 'gv',
                'name' => [
                    'en' => 'Manx',
                    'gv' => 'Gaelg, Gailck',
                    'hu' => 'Manx',
                ],
            ],
            [
                'code' => 'mk',
                'name' => [
                    'en' => 'Macedonian',
                    'mk' => 'македонски јазик',
                    'hu' => 'Macedón',
                ],
            ],
            [
                'code' => 'mg',
                'name' => [
                    'en' => 'Malagasy',
                    'mg' => 'Malagasy fiteny',
                    'hu' => 'Malagaszi',
                ],
            ],
            [
                'code' => 'ms',
                'name' => [
                    'en' => 'Malay',
                    'ms' => 'bahasa Melayu, بهاس ملايو‎',
                    'hu' => 'Maláj',
                ],
            ],
            [
                'code' => 'ml',
                'name' => [
                    'en' => 'Malayalam',
                    'ml' => 'മലയാളം',
                    'hu' => 'Malayalam',
                ],
            ],
            [
                'code' => 'mt',
                'name' => [
                    'en' => 'Maltese',
                    'mt' => 'Malti',
                    'hu' => 'Máltai',
                ],
            ],
            [
                'code' => 'mi',
                'name' => [
                    'en' => 'Māori',
                    'mi' => 'te reo Māori',
                    'hu' => 'Maori',
                ],
            ],
            [
                'code' => 'mr',
                'name' => [
                    'en' => 'Marathi (Marāṭhī)',
                    'mr' => 'मराठी',
                    'hu' => 'Marathi',
                ],
            ],
            [
                'code' => 'mh',
                'name' => [
                    'en' => 'Marshallese',
                    'mh' => 'Kajin M̧ajeļ',
                    'hu' => 'Marshall-szigeti',
                ],
            ],
            [
                'code' => 'mn',
                'name' => [
                    'en' => 'Mongolian',
                    'mn' => 'монгол',
                    'hu' => 'Mongol',
                ],
            ],
            [
                'code' => 'na',
                'name' => [
                    'en' => 'Nauru',
                    'na' => 'Ekakairũ Naoero',
                    'hu' => 'Naurui',
                ],
            ],
            [
                'code' => 'nv',
                'name' => [
                    'en' => 'Navajo, Navaho',
                    'nv' => 'Diné bizaad, Dinékʼehǰí',
                    'hu' => 'Navaho',
                ],
            ],
            [
                'code' => 'nb',
                'name' => [
                    'en' => 'Norwegian Bokmål',
                    'nb' => 'Norsk bokmål',
                    'hu' => 'Norvég Bokmål',
                ],
            ],
            [
                'code' => 'nd',
                'name' => [
                    'en' => 'North Ndebele',
                    'nd' => 'isiNdebele',
                    'hu' => 'Észak-ndebele',
                ],
            ],
            [
                'code' => 'ne',
                'name' => [
                    'en' => 'Nepali',
                    'ne' => 'नेपाली',
                    'hu' => 'Nepáli',
                ],
            ],
            [
                'code' => 'ng',
                'name' => [
                    'en' => 'Ndonga',
                    'ng' => 'Owambo',
                    'hu' => 'Ndonga',
                ],
            ],
            [
                'code' => 'nn',
                'name' => [
                    'en' => 'Norwegian Nynorsk',
                    'nn' => 'Norsk nynorsk',
                    'hu' => 'Norvég Nynorsk',
                ],
            ],
            [
                'code' => 'no',
                'name' => [
                    'en' => 'Norwegian',
                    'no' => 'Norsk',
                    'hu' => 'Norvég',
                ],
            ],
            [
                'code' => 'ii',
                'name' => [
                    'en' => 'Nuosu',
                    'ii' => 'ꆈꌠ꒿ Nuosuhxop',
                    'hu' => 'Nuoszu',
                ],
            ],
            [
                'code' => 'nr',
                'name' => [
                    'en' => 'South Ndebele',
                    'nr' => 'isiNdebele',
                    'hu' => 'Dél-ndebele',
                ],
            ],
            [
                'code' => 'oc',
                'name' => [
                    'en' => 'Occitan',
                    'oc' => 'Occitan',
                    'hu' => 'Okcitán',
                ],
            ],
            [
                'code' => 'oj',
                'name' => [
                    'en' => 'Ojibwe, Ojibwa',
                    'oj' => 'ᐊᓂᔑᓈᐯᒧᐎᓐ',
                    'hu' => 'Ojibwa',
                ],
            ],
            [
                'code' => 'cu',
                'name' => [
                    'en' => 'Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic',
                    'cu' => 'ѩзыкъ словѣньскъ',
                    'hu' => 'Egyházi szláv',
                ],
            ],
            [
                'code' => 'om',
                'name' => [
                    'en' => 'Oromo',
                    'om' => 'Afaan Oromoo',
                    'hu' => 'Oromo',
                ],
            ],
            [
                'code' => 'or',
                'name' => [
                    'en' => 'Oriya',
                    'or' => 'ଓଡ଼ିଆ',
                    'hu' => 'Orija',
                ],
            ],
            [
                'code' => 'os',
                'name' => [
                    'en' => 'Ossetian, Ossetic',
                    'os' => 'ирон æвзаг',
                    'hu' => 'Oszét',
                ],
            ],
            [
                'code' => 'pa',
                'name' => [
                    'en' => 'Panjabi, Punjabi',
                    'pa' => 'ਪੰਜਾਬੀ, پنجابی‎',
                    'hu' => 'Pandzsábi',
                ],
            ],
            [
                'code' => 'pi',
                'name' => [
                    'en' => 'Pāli',
                    'pi' => 'पाऴि',
                    'hu' => 'Páli',
                ],
            ],
            [
                'code' => 'fa',
                'name' => [
                    'en' => 'Persian',
                    'fa' => 'فارسی',
                    'hu' => 'Perzsa',
                ],
            ],
            [
                'code' => 'pl',
                'name' => [
                    'en' => 'Polish',
                    'pl' => 'polski',
                    'hu' => 'Lengyel',
                ],
            ],
            [
                'code' => 'ps',
                'name' => [
                    'en' => 'Pashto, Pushto',
                    'ps' => 'پښتو',
                    'hu' => 'Pastu',
                ],
            ],
            [
                'code' => 'pt',
                'name' => [
                    'en' => 'Portuguese',
                    'pt' => 'Português',
                    'hu' => 'Portugál',
                ],
            ],
            [
                'code' => 'qu',
                'name' => [
                    'en' => 'Quechua',
                    'qu' => 'Runa Simi, Kichwa',
                    'hu' => 'Kecsuva',
                ],
            ],
            [
                'code' => 'rm',
                'name' => [
                    'en' => 'Romansh',
                    'rm' => 'rumantsch grischun',
                    'hu' => 'Román',
                ],
            ],
            [
                'code' => 'rn',
                'name' => [
                    'en' => 'Kirundi',
                    'rn' => 'kiRundi',
                    'hu' => 'Kirundi',
                ],
            ],
            [
                'code' => 'ro',
                'name' => [
                    'en' => 'Romanian, Moldavian, Moldovan',
                    'ro' => 'română',
                    'hu' => 'Román',
                ],
            ],
            [
                'code' => 'ru',
                'name' => [
                    'en' => 'Russian',
                    'ru' => 'русский язык',
                    'hu' => 'Orosz',
                ],
            ],
            [
                'code' => 'sa',
                'name' => [
                    'en' => 'Sanskrit (Saṁskṛta)',
                    'sa' => 'संस्कृतम्',
                    'hu' => 'Szanszkrit',
                ],
            ],
            [
                'code' => 'sc',
                'name' => [
                    'en' => 'Sardinian',
                    'sc' => 'sardu',
                    'hu' => 'Szardíniai',
                ],
            ],
            [
                'code' => 'sd',
                'name' => [
                    'en' => 'Sindhi',
                    'sd' => 'सिन्धी, سنڌي، سندھی‎',
                    'hu' => 'Szindi',
                ],
            ],
            [
                'code' => 'se',
                'name' => [
                    'en' => 'Northern Sami',
                    'se' => 'Davvisámegiella',
                    'hu' => 'Északi számi',
                ],
            ],
            [
                'code' => 'sm',
                'name' => [
                    'en' => 'Samoan',
                    'sm' => 'gagana faa Samoa',
                    'hu' => 'Szamoai',
                ],
            ],
            [
                'code' => 'sg',
                'name' => [
                    'en' => 'Sango',
                    'sg' => 'yângâ tî sängö',
                    'hu' => 'Szangó',
                ],
            ],
            [
                'code' => 'sr',
                'name' => [
                    'en' => 'Serbian',
                    'sr' => 'српски језик',
                    'hu' => 'Szerb',
                ],
            ],
            [
                'code' => 'gd',
                'name' => [
                    'en' => 'Scottish Gaelic; Gaelic',
                    'gd' => 'Gàidhlig',
                    'hu' => 'Skót gael',
                ],
            ],
            [
                'code' => 'sn',
                'name' => [
                    'en' => 'Shona',
                    'sn' => 'chiShona',
                    'hu' => 'Shona',
                ],
            ],
            [
                'code' => 'si',
                'name' => [
                    'en' => 'Sinhala, Sinhalese',
                    'si' => 'සිංහල',
                    'hu' => 'Szingaléz',
                ],
            ],
            [
                'code' => 'sk',
                'name' => [
                    'en' => 'Slovak',
                    'sk' => 'slovenčina',
                    'hu' => 'Szlovák',
                ],
            ],
            [
                'code' => 'sl',
                'name' => [
                    'en' => 'Slovene',
                    'sl' => 'slovenščina',
                    'hu' => 'Szlovén',
                ],
            ],
            [
                'code' => 'so',
                'name' => [
                    'en' => 'Somali',
                    'so' => 'Soomaaliga, af Soomaali',
                    'hu' => 'Szomáli',
                ],
            ],
            [
                'code' => 'st',
                'name' => [
                    'en' => 'Southern Sotho',
                    'st' => 'Sesotho',
                    'hu' => 'Dél-szotó',
                ],
            ],
            [
                'code' => 'es',
                'name' => [
                    'en' => 'Spanish; Castilian',
                    'es' => 'español, castellano',
                    'hu' => 'Спанielski',
                ],
            ],
            [
                'code' => 'su',
                'name' => [
                    'en' => 'Sundanese',
                    'su' => 'Basa Sunda',
                    'hu' => 'Szundanéz',
                ],
            ],
            [
                'code' => 'sw',
                'name' => [
                    'en' => 'Swahili',
                    'sw' => 'Kiswahili',
                    'hu' => 'Szuahéli',
                ],
            ],
            [
                'code' => 'ss',
                'name' => [
                    'en' => 'Swati',
                    'ss' => 'SiSwati',
                    'hu' => 'Szuati',
                ],
            ],
            [
                'code' => 'sv',
                'name' => [
                    'en' => 'Swedish',
                    'sv' => 'svenska',
                    'hu' => 'Svéd',
                ],
            ],
            [
                'code' => 'ta',
                'name' => [
                    'en' => 'Tamil',
                    'ta' => 'தமிழ்',
                    'hu' => 'Tamil',
                ],
            ],
            [
                'code' => 'te',
                'name' => [
                    'en' => 'Telugu',
                    'te' => 'తెలుగు',
                    'hu' => 'Telugu',
                ],
            ],
            [
                'code' => 'tg',
                'name' => [
                    'en' => 'Tajik',
                    'tg' => 'тоҷикӣ, toğikī, تاجیکی‎',
                    'hu' => 'Tádzsik',
                ],
            ],
            [
                'code' => 'th',
                'name' => [
                    'en' => 'Thai',
                    'th' => 'ไทย',
                    'hu' => 'Thai',
                ],
            ],
            [
                'code' => 'ti',
                'name' => [
                    'en' => 'Tigrinya',
                    'ti' => 'ትግርኛ',
                    'hu' => 'Tigrinya',
                ],
            ],
            [
                'code' => 'bo',
                'name' => [
                    'en' => 'Tibetan Standard, Tibetan, Central',
                    'bo' => 'བོད་ཡིག',
                    'hu' => 'Tibeti',
                ],
            ],
            [
                'code' => 'tk',
                'name' => [
                    'en' => 'Turkmen',
                    'tk' => 'Türkmen, Түркмен',
                    'hu' => 'Türkmén',
                ],
            ],
            [
                'code' => 'tl',
                'name' => [
                    'en' => 'Tagalog',
                    'tl' => 'Wikang Tagalog, ᜏᜒᜃᜅ᜔ ᜆᜄᜎᜓᜄ᜔',
                    'hu' => 'Tagalog',
                ],
            ],
            [
                'code' => 'tn',
                'name' => [
                    'en' => 'Tswana',
                    'tn' => 'Setswana',
                    'hu' => 'Tswana',
                ],
            ],
            [
                'code' => 'to',
                'name' => [
                    'en' => 'Tonga (Tonga Islands)',
                    'to' => 'faka Tonga',
                    'hu' => 'Tongai',
                ],
            ],
            [
                'code' => 'tr',
                'name' => [
                    'en' => 'Turkish',
                    'tr' => 'Türkçe',
                    'hu' => 'Török',
                ],
            ],
            [
                'code' => 'ts',
                'name' => [
                    'en' => 'Tsonga',
                    'ts' => 'Xitsonga',
                    'hu' => 'Tsonga',
                ],
            ],
            [
                'code' => 'tt',
                'name' => [
                    'en' => 'Tatar',
                    'tt' => 'татарча, tatarça, تاتارچا‎',
                    'hu' => 'Tatár',
                ],
            ],
            [
                'code' => 'tw',
                'name' => [
                    'en' => 'Twi',
                    'tw' => 'Twi',
                    'hu' => 'Twi',
                ],
            ],
            [
                'code' => 'ty',
                'name' => [
                    'en' => 'Tahitian',
                    'ty' => 'Reo Tahiti',
                    'hu' => 'Tahiti',
                ],
            ],
            [
                'code' => 'ug',
                'name' => [
                    'en' => 'Uighur, Uyghur',
                    'ug' => 'Uyƣurqə, ئۇيغۇرچە‎',
                    'hu' => 'Ujgur',
                ],
            ],
            [
                'code' => 'uk',
                'name' => [
                    'en' => 'Ukrainian',
                    'uk' => 'українська',
                    'hu' => 'Ukrán',
                ],
            ],
            [
                'code' => 'ur',
                'name' => [
                    'en' => 'Urdu',
                    'ur' => 'اردو',
                    'hu' => 'Urdu',
                ],
            ],
            [
                'code' => 'uz',
                'name' => [
                    'en' => 'Uzbek',
                    'uz' => 'zbek, Ўзбек, أۇزبېك‎',
                    'hu' => 'Üzbég',
                ],
            ],
            [
                'code' => 've',
                'name' => [
                    'en' => 'Venda',
                    've' => 'Tshivenḓa',
                    'hu' => 'Venda',
                ],
            ],
            [
                'code' => 'vi',
                'name' => [
                    'en' => 'Vietnamese',
                    'vi' => 'Tiếng Việt',
                    'hu' => 'Vietnami',
                ],
            ],
            [
                'code' => 'vo',
                'name' => [
                    'en' => 'Volapük',
                    'vo' => 'Volapük',
                    'hu' => 'Volapük',
                ],
            ],
            [
                'code' => 'wa',
                'name' => [
                    'en' => 'Walloon',
                    'wa' => 'Walon',
                    'hu' => 'Vallon',
                ],
            ],
            [
                'code' => 'cy',
                'name' => [
                    'en' => 'Welsh',
                    'cy' => 'Cymraeg',
                    'hu' => 'Walesi',
                ],
            ],
            [
                'code' => 'wo',
                'name' => [
                    'en' => 'Wolof',
                    'wo' => 'Wollof',
                    'hu' => 'Volof',
                ],
            ],
            [
                'code' => 'fy',
                'name' => [
                    'en' => 'Western Frisian',
                    'fy' => 'Frysk',
                    'hu' => 'Nyugat-fríz',
                ],
            ],
            [
                'code' => 'xh',
                'name' => [
                    'en' => 'Xhosa',
                    'xh' => 'isiXhosa',
                    'hu' => 'Xhosa',
                ],
            ],
            [
                'code' => 'yi',
                'name' => [
                    'en' => 'Yiddish',
                    'yi' => 'ייִדיש',
                    'hu' => 'Jiddis',
                ],
            ],
            [
                'code' => 'yo',
                'name' => [
                    'en' => 'Yoruba',
                    'yo' => 'Yorùbá',
                    'hu' => 'Joruba',
                ],
            ],
            [
                'code' => 'za',
                'name' => [
                    'en' => 'Zhuang, Chuang',
                    'za' => 'Saɯ cueŋƅ, Saw cuengh',
                    'hu' => 'Zsuang',
                ],
            ],
        ];

        foreach ($languages as $languageData) {
            $language = new Language;
            $language->code = $languageData['code'];
            $language->enabled = isset($languageData['enabled']) ? $languageData['enabled'] : false;
            $language->save();
        }

        $languageRepository = app(LanguageRepositoryInterface::class);
        foreach ($languages as $languageData) {
            $language = $languageRepository->getByCode($languageData['code']);
            foreach ($languageData['name'] as $languageCode => $name) {
                $language->setCurrentCode($languageCode);
                $language->name = $name;
                $language->save();
            }
        }
    }
}
