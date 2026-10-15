<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Valideringsmeldinger
    |--------------------------------------------------------------------------
    |
    | Følgende språkstrenger inneholder standard feilmeldinger som brukes
    | av validatoren. Noen regler har flere versjoner, for eksempel
    | størrelsesreglene.
    |
    */

    'accepted' => ':attribute må aksepteres.',
    'accepted_if' => ':attribute må aksepteres når :other er :value.',
    'active_url' => ':attribute må være en gyldig URL.',
    'after' => ':attribute må være en dato etter :date.',
    'after_or_equal' => ':attribute må være en dato etter eller lik :date.',
    'alpha' => ':attribute kan bare inneholde bokstaver.',
    'alpha_dash' => ':attribute kan bare inneholde bokstaver, tall, bindestreker og understreker.',
    'alpha_num' => ':attribute kan bare inneholde bokstaver og tall.',
    'any_of' => ':attribute er ugyldig.',
    'array' => ':attribute må være en liste.',
    'array_keys' => ':attribute kan bare inneholde følgende nøkler: :values.',
    'ascii' => ':attribute kan bare inneholde alfanumeriske enkeltbytetegn og symboler.',
    'base64' => ':attribute må være en gyldig Base64-streng.',
    'before' => ':attribute må være en dato før :date.',
    'before_or_equal' => ':attribute må være en dato før eller lik :date.',

    'between' => [
        'array' => ':attribute må ha mellom :min og :max elementer.',
        'file' => ':attribute må være mellom :min og :max kilobyte.',
        'numeric' => ':attribute må være mellom :min og :max.',
        'string' => ':attribute må være mellom :min og :max tegn.',
    ],

    'boolean' => ':attribute må være sann eller usann.',
    'can' => ':attribute inneholder en verdi du ikke har tilgang til.',
    'confirmed' => 'Bekreftelsen av :attribute samsvarer ikke.',
    'contains' => ':attribute mangler en påkrevd verdi.',
    'current_password' => 'Passordet er feil.',
    'date' => ':attribute må være en gyldig dato.',
    'date_equals' => ':attribute må være en dato lik :date.',
    'date_format' => ':attribute må samsvare med formatet :format.',
    'decimal' => ':attribute må ha :decimal desimaler.',
    'declined' => ':attribute må avslås.',
    'declined_if' => ':attribute må avslås når :other er :value.',
    'different' => ':attribute og :other må være forskjellige.',
    'digits' => ':attribute må være :digits sifre.',
    'digits_between' => ':attribute må være mellom :min og :max sifre.',
    'dimensions' => ':attribute har ugyldige bildedimensjoner.',
    'distinct' => ':attribute har en duplikatverdi.',
    'doesnt_contain' => ':attribute kan ikke inneholde noen av følgende verdier: :values.',
    'doesnt_end_with' => ':attribute kan ikke slutte med noen av følgende verdier: :values.',
    'doesnt_start_with' => ':attribute kan ikke starte med noen av følgende verdier: :values.',
    'email' => ':attribute må være en gyldig e-postadresse.',
    'encoding' => ':attribute må være kodet med :encoding.',
    'ends_with' => ':attribute må slutte med en av følgende verdier: :values.',
    'enum' => 'Valgt :attribute er ugyldig.',
    'exists' => 'Valgt :attribute er ugyldig.',
    'extensions' => ':attribute må ha en av følgende filendelser: :values.',
    'file' => ':attribute må være en fil.',
    'filled' => ':attribute må ha en verdi.',

    'gt' => [
        'array' => ':attribute må ha mer enn :value elementer.',
        'file' => ':attribute må være større enn :value kilobyte.',
        'numeric' => ':attribute må være større enn :value.',
        'string' => ':attribute må være lengre enn :value tegn.',
    ],

    'gte' => [
        'array' => ':attribute må ha :value elementer eller flere.',
        'file' => ':attribute må være større enn eller lik :value kilobyte.',
        'numeric' => ':attribute må være større enn eller lik :value.',
        'string' => ':attribute må være minst :value tegn.',
    ],

    'hex_color' => ':attribute må være en gyldig heksadesimal farge.',
    'image' => ':attribute må være et bilde.',
    'in' => 'Valgt :attribute er ugyldig.',
    'in_array' => ':attribute må finnes i :other.',
    'in_array_keys' => ':attribute må inneholde minst én av følgende nøkler: :values.',
    'integer' => ':attribute må være et heltall.',
    'ip' => ':attribute må være en gyldig IP-adresse.',
    'ipv4' => ':attribute må være en gyldig IPv4-adresse.',
    'ipv6' => ':attribute må være en gyldig IPv6-adresse.',
    'json' => ':attribute må være en gyldig JSON-streng.',
    'list' => ':attribute må være en liste.',
    'lowercase' => ':attribute må være skrevet med små bokstaver.',

    'lt' => [
        'array' => ':attribute må ha færre enn :value elementer.',
        'file' => ':attribute må være mindre enn :value kilobyte.',
        'numeric' => ':attribute må være mindre enn :value.',
        'string' => ':attribute må være kortere enn :value tegn.',
    ],

    'lte' => [
        'array' => ':attribute kan ikke ha mer enn :value elementer.',
        'file' => ':attribute må være mindre enn eller lik :value kilobyte.',
        'numeric' => ':attribute må være mindre enn eller lik :value.',
        'string' => ':attribute kan ikke være lengre enn :value tegn.',
    ],

    'mac_address' => ':attribute må være en gyldig MAC-adresse.',

    'max' => [
        'array' => ':attribute kan ikke ha mer enn :max elementer.',
        'file' => ':attribute kan ikke være større enn :max kilobyte.',
        'numeric' => ':attribute kan ikke være større enn :max.',
        'string' => ':attribute kan ikke være lengre enn :max tegn.',
    ],

    'max_digits' => ':attribute kan ikke ha mer enn :max sifre.',
    'mimes' => ':attribute må være en fil av typen: :values.',
    'mimetypes' => ':attribute må være en fil av typen: :values.',

    'min' => [
        'array' => ':attribute må ha minst :min elementer.',
        'file' => ':attribute må være minst :min kilobyte.',
        'numeric' => ':attribute må være minst :min.',
        'string' => ':attribute må være minst :min tegn.',
    ],

    'min_digits' => ':attribute må ha minst :min sifre.',
    'missing' => ':attribute må mangle.',
    'missing_if' => ':attribute må mangle når :other er :value.',
    'missing_unless' => ':attribute må mangle med mindre :other er :value.',
    'missing_with' => ':attribute må mangle når :values finnes.',
    'missing_with_all' => ':attribute må mangle når :values finnes.',
    'multiple_of' => ':attribute må være et multiplum av :value.',
    'not_in' => 'Valgt :attribute er ugyldig.',
    'not_regex' => 'Formatet til :attribute er ugyldig.',
    'numeric' => ':attribute må være et tall.',

    'password' => [
        'letters' => ':attribute må inneholde minst én bokstav.',
        'mixed' => ':attribute må inneholde minst én stor og én liten bokstav.',
        'numbers' => ':attribute må inneholde minst ett tall.',
        'symbols' => ':attribute må inneholde minst ett symbol.',
        'uncompromised' => ':attribute har blitt funnet i en datalekkasje. Velg en annen :attribute.',
    ],

    'present' => ':attribute må være til stede.',
    'present_if' => ':attribute må være til stede når :other er :value.',
    'present_unless' => ':attribute må være til stede med mindre :other er :value.',
    'present_with' => ':attribute må være til stede når :values finnes.',
    'present_with_all' => ':attribute må være til stede når :values finnes.',
    'prohibited' => ':attribute er ikke tillatt.',
    'prohibited_if' => ':attribute er ikke tillatt når :other er :value.',
    'prohibited_if_accepted' => ':attribute er ikke tillatt når :other er akseptert.',
    'prohibited_if_declined' => ':attribute er ikke tillatt når :other er avslått.',
    'prohibited_unless' => ':attribute er ikke tillatt med mindre :other finnes i :values.',
    'prohibits' => ':attribute hindrer :other i å være til stede.',
    'regex' => 'Formatet til :attribute er ugyldig.',
    'required' => ':attribute er påkrevd.',
    'required_array_keys' => ':attribute må inneholde oppføringer for: :values.',
    'required_if' => ':attribute er påkrevd når :other er :value.',
    'required_if_accepted' => ':attribute er påkrevd når :other er akseptert.',
    'required_if_declined' => ':attribute er påkrevd når :other er avslått.',
    'required_unless' => ':attribute er påkrevd med mindre :other finnes i :values.',
    'required_with' => ':attribute er påkrevd når :values finnes.',
    'required_with_all' => ':attribute er påkrevd når :values finnes.',
    'required_without' => ':attribute er påkrevd når :values ikke finnes.',
    'required_without_all' => ':attribute er påkrevd når ingen av :values finnes.',
    'same' => ':attribute må samsvare med :other.',

    'size' => [
        'array' => ':attribute må inneholde :size elementer.',
        'file' => ':attribute må være :size kilobyte.',
        'numeric' => ':attribute må være :size.',
        'string' => ':attribute må være :size tegn.',
    ],

    'starts_with' => ':attribute må starte med en av følgende verdier: :values.',
    'string' => ':attribute må være en tekststreng.',
    'timezone' => ':attribute må være en gyldig tidssone.',
    'unique' => ':attribute er allerede i bruk.',
    'uploaded' => 'Opplastingen av :attribute mislyktes.',
    'uppercase' => ':attribute må være skrevet med store bokstaver.',
    'url' => ':attribute må være en gyldig URL.',
    'ulid' => ':attribute må være en gyldig ULID.',
    'uuid' => ':attribute må være en gyldig UUID.',

    /*
    |--------------------------------------------------------------------------
    | Egendefinerte valideringsmeldinger
    |--------------------------------------------------------------------------
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Egendefinerte attributtnavn
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'first_name' => 'fornavn',
        'last_name' => 'etternavn',
        'username' => 'brukernavn',
        'email' => 'e-post',
        'profile_photo' => 'profilbilde',
        'bio' => 'biografi',
        'gender' => 'kjønn',
        'date_of_birth' => 'fødselsdato',
    ],

];
