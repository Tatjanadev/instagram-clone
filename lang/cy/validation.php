<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Negeseuon Iaith Dilysu
    |--------------------------------------------------------------------------
    |
    | Mae'r llinellau iaith canlynol yn cynnwys y negeseuon gwall diofyn
    | a ddefnyddir gan y dilysydd.
    |
    */

    'accepted' => 'Rhaid derbyn :attribute.',
    'accepted_if' => 'Rhaid derbyn :attribute pan fo :other yn :value.',
    'active_url' => 'Rhaid i :attribute fod yn URL dilys.',
    'after' => 'Rhaid i :attribute fod yn ddyddiad ar ôl :date.',
    'after_or_equal' => 'Rhaid i :attribute fod yn ddyddiad ar ôl neu yn hafal i :date.',
    'alpha' => 'Dim ond llythrennau y gall :attribute eu cynnwys.',
    'alpha_dash' => 'Dim ond llythrennau, rhifau, cysylltnodau a thanlinellau y gall :attribute eu cynnwys.',
    'alpha_num' => 'Dim ond llythrennau a rhifau y gall :attribute eu cynnwys.',
    'any_of' => 'Mae :attribute yn annilys.',
    'array' => 'Rhaid i :attribute fod yn arae.',
    'array_keys' => 'Dim ond yr allweddi canlynol y gall :attribute eu cynnwys: :values.',
    'ascii' => 'Dim ond nodau alffaniwmerig un beit a symbolau y gall :attribute eu cynnwys.',
    'base64' => 'Rhaid i :attribute fod yn llinyn Base64 dilys.',
    'before' => 'Rhaid i :attribute fod yn ddyddiad cyn :date.',
    'before_or_equal' => 'Rhaid i :attribute fod yn ddyddiad cyn neu yn hafal i :date.',

    'between' => [
        'array' => 'Rhaid i :attribute gynnwys rhwng :min a :max eitem.',
        'file' => 'Rhaid i :attribute fod rhwng :min a :max cilobeit.',
        'numeric' => 'Rhaid i :attribute fod rhwng :min a :max.',
        'string' => 'Rhaid i :attribute fod rhwng :min a :max nod.',
    ],

    'boolean' => 'Rhaid i :attribute fod yn wir neu anwir.',
    'can' => 'Mae :attribute yn cynnwys gwerth heb awdurdod.',
    'confirmed' => 'Nid yw cadarnhad :attribute yn cyfateb.',
    'contains' => 'Mae gwerth gofynnol ar goll o :attribute.',
    'current_password' => 'Mae’r cyfrinair yn anghywir.',
    'date' => 'Rhaid i :attribute fod yn ddyddiad dilys.',
    'date_equals' => 'Rhaid i :attribute fod yn ddyddiad sy’n hafal i :date.',
    'date_format' => 'Rhaid i :attribute gyd-fynd â’r fformat :format.',
    'decimal' => 'Rhaid i :attribute gynnwys :decimal lle degol.',
    'declined' => 'Rhaid gwrthod :attribute.',
    'declined_if' => 'Rhaid gwrthod :attribute pan fo :other yn :value.',
    'different' => 'Rhaid i :attribute a :other fod yn wahanol.',
    'digits' => 'Rhaid i :attribute gynnwys :digits digid.',
    'digits_between' => 'Rhaid i :attribute gynnwys rhwng :min a :max digid.',
    'dimensions' => 'Mae gan :attribute ddimensiynau delwedd annilys.',
    'distinct' => 'Mae gan :attribute werth dyblyg.',
    'doesnt_contain' => 'Ni chaiff :attribute gynnwys unrhyw un o’r canlynol: :values.',
    'doesnt_end_with' => 'Ni chaiff :attribute orffen gydag unrhyw un o’r canlynol: :values.',
    'doesnt_start_with' => 'Ni chaiff :attribute ddechrau gydag unrhyw un o’r canlynol: :values.',
    'email' => 'Rhaid i :attribute fod yn gyfeiriad e-bost dilys.',
    'encoding' => 'Rhaid i :attribute gael ei amgodio gan ddefnyddio :encoding.',
    'ends_with' => 'Rhaid i :attribute orffen gydag un o’r canlynol: :values.',
    'enum' => 'Mae’r :attribute a ddewiswyd yn annilys.',
    'exists' => 'Mae’r :attribute a ddewiswyd yn annilys.',
    'extensions' => 'Rhaid i :attribute fod ag un o’r estyniadau canlynol: :values.',
    'file' => 'Rhaid i :attribute fod yn ffeil.',
    'filled' => 'Rhaid i :attribute gynnwys gwerth.',

    'gt' => [
        'array' => 'Rhaid i :attribute gynnwys mwy na :value eitem.',
        'file' => 'Rhaid i :attribute fod yn fwy na :value cilobeit.',
        'numeric' => 'Rhaid i :attribute fod yn fwy na :value.',
        'string' => 'Rhaid i :attribute fod yn fwy na :value nod.',
    ],

    'gte' => [
        'array' => 'Rhaid i :attribute gynnwys :value eitem neu fwy.',
        'file' => 'Rhaid i :attribute fod yn fwy na neu’n hafal i :value cilobeit.',
        'numeric' => 'Rhaid i :attribute fod yn fwy na neu’n hafal i :value.',
        'string' => 'Rhaid i :attribute fod yn :value nod neu fwy.',
    ],

    'hex_color' => 'Rhaid i :attribute fod yn lliw hecsadegol dilys.',
    'image' => 'Rhaid i :attribute fod yn ddelwedd.',
    'in' => 'Mae’r :attribute a ddewiswyd yn annilys.',
    'in_array' => 'Rhaid i :attribute fodoli yn :other.',
    'in_array_keys' => 'Rhaid i :attribute gynnwys o leiaf un o’r allweddi canlynol: :values.',
    'integer' => 'Rhaid i :attribute fod yn gyfanrif.',
    'ip' => 'Rhaid i :attribute fod yn gyfeiriad IP dilys.',
    'ipv4' => 'Rhaid i :attribute fod yn gyfeiriad IPv4 dilys.',
    'ipv6' => 'Rhaid i :attribute fod yn gyfeiriad IPv6 dilys.',
    'json' => 'Rhaid i :attribute fod yn llinyn JSON dilys.',
    'list' => 'Rhaid i :attribute fod yn rhestr.',
    'lowercase' => 'Rhaid i :attribute fod mewn llythrennau bach.',

    'lt' => [
        'array' => 'Rhaid i :attribute gynnwys llai na :value eitem.',
        'file' => 'Rhaid i :attribute fod yn llai na :value cilobeit.',
        'numeric' => 'Rhaid i :attribute fod yn llai na :value.',
        'string' => 'Rhaid i :attribute fod yn llai na :value nod.',
    ],

    'lte' => [
        'array' => 'Ni chaiff :attribute gynnwys mwy na :value eitem.',
        'file' => 'Rhaid i :attribute fod yn llai na neu’n hafal i :value cilobeit.',
        'numeric' => 'Rhaid i :attribute fod yn llai na neu’n hafal i :value.',
        'string' => 'Ni chaiff :attribute fod yn fwy na :value nod.',
    ],

    'mac_address' => 'Rhaid i :attribute fod yn gyfeiriad MAC dilys.',

    'max' => [
        'array' => 'Ni chaiff :attribute gynnwys mwy na :max eitem.',
        'file' => 'Ni chaiff :attribute fod yn fwy na :max cilobeit.',
        'numeric' => 'Ni chaiff :attribute fod yn fwy na :max.',
        'string' => 'Ni chaiff :attribute fod yn fwy na :max nod.',
    ],

    'max_digits' => 'Ni chaiff :attribute gynnwys mwy na :max digid.',
    'mimes' => 'Rhaid i :attribute fod yn ffeil o’r math: :values.',
    'mimetypes' => 'Rhaid i :attribute fod yn ffeil o’r math: :values.',

    'min' => [
        'array' => 'Rhaid i :attribute gynnwys o leiaf :min eitem.',
        'file' => 'Rhaid i :attribute fod o leiaf :min cilobeit.',
        'numeric' => 'Rhaid i :attribute fod o leiaf :min.',
        'string' => 'Rhaid i :attribute fod o leiaf :min nod.',
    ],

    'min_digits' => 'Rhaid i :attribute gynnwys o leiaf :min digid.',
    'missing' => 'Rhaid i :attribute fod ar goll.',
    'missing_if' => 'Rhaid i :attribute fod ar goll pan fo :other yn :value.',
    'missing_unless' => 'Rhaid i :attribute fod ar goll oni bai bod :other yn :value.',
    'missing_with' => 'Rhaid i :attribute fod ar goll pan fo :values yn bresennol.',
    'missing_with_all' => 'Rhaid i :attribute fod ar goll pan fo :values yn bresennol.',
    'multiple_of' => 'Rhaid i :attribute fod yn luosrif o :value.',
    'not_in' => 'Mae’r :attribute a ddewiswyd yn annilys.',
    'not_regex' => 'Mae fformat :attribute yn annilys.',
    'numeric' => 'Rhaid i :attribute fod yn rhif.',

    'password' => [
        'letters' => 'Rhaid i :attribute gynnwys o leiaf un llythyren.',
        'mixed' => 'Rhaid i :attribute gynnwys o leiaf un llythyren fawr ac un llythyren fach.',
        'numbers' => 'Rhaid i :attribute gynnwys o leiaf un rhif.',
        'symbols' => 'Rhaid i :attribute gynnwys o leiaf un symbol.',
        'uncompromised' => 'Mae’r :attribute a roddwyd wedi ymddangos mewn gollyngiad data. Dewiswch :attribute gwahanol.',
    ],

    'present' => 'Rhaid i :attribute fod yn bresennol.',
    'present_if' => 'Rhaid i :attribute fod yn bresennol pan fo :other yn :value.',
    'present_unless' => 'Rhaid i :attribute fod yn bresennol oni bai bod :other yn :value.',
    'present_with' => 'Rhaid i :attribute fod yn bresennol pan fo :values yn bresennol.',
    'present_with_all' => 'Rhaid i :attribute fod yn bresennol pan fo :values yn bresennol.',
    'prohibited' => 'Ni chaniateir :attribute.',
    'prohibited_if' => 'Ni chaniateir :attribute pan fo :other yn :value.',
    'prohibited_if_accepted' => 'Ni chaniateir :attribute pan fo :other wedi’i dderbyn.',
    'prohibited_if_declined' => 'Ni chaniateir :attribute pan fo :other wedi’i wrthod.',
    'prohibited_unless' => 'Ni chaniateir :attribute oni bai bod :other yn :values.',
    'prohibits' => 'Mae :attribute yn atal :other rhag bod yn bresennol.',
    'regex' => 'Mae fformat :attribute yn annilys.',
    'required' => 'Mae :attribute yn ofynnol.',
    'required_array_keys' => 'Rhaid i :attribute gynnwys cofnodion ar gyfer: :values.',
    'required_if' => 'Mae :attribute yn ofynnol pan fo :other yn :value.',
    'required_if_accepted' => 'Mae :attribute yn ofynnol pan fo :other wedi’i dderbyn.',
    'required_if_declined' => 'Mae :attribute yn ofynnol pan fo :other wedi’i wrthod.',
    'required_unless' => 'Mae :attribute yn ofynnol oni bai bod :other yn :values.',
    'required_with' => 'Mae :attribute yn ofynnol pan fo :values yn bresennol.',
    'required_with_all' => 'Mae :attribute yn ofynnol pan fo :values yn bresennol.',
    'required_without' => 'Mae :attribute yn ofynnol pan nad yw :values yn bresennol.',
    'required_without_all' => 'Mae :attribute yn ofynnol pan nad oes unrhyw un o :values yn bresennol.',
    'same' => 'Rhaid i :attribute gyd-fynd â :other.',

    'size' => [
        'array' => 'Rhaid i :attribute gynnwys :size eitem.',
        'file' => 'Rhaid i :attribute fod yn :size cilobeit.',
        'numeric' => 'Rhaid i :attribute fod yn :size.',
        'string' => 'Rhaid i :attribute fod yn :size nod.',
    ],

    'starts_with' => 'Rhaid i :attribute ddechrau gydag un o’r canlynol: :values.',
    'string' => 'Rhaid i :attribute fod yn llinyn.',
    'timezone' => 'Rhaid i :attribute fod yn gylchfa amser ddilys.',
    'unique' => 'Mae :attribute eisoes wedi’i ddefnyddio.',
    'uploaded' => 'Methodd uwchlwytho :attribute.',
    'uppercase' => 'Rhaid i :attribute fod mewn priflythrennau.',
    'url' => 'Rhaid i :attribute fod yn URL dilys.',
    'ulid' => 'Rhaid i :attribute fod yn ULID dilys.',
    'uuid' => 'Rhaid i :attribute fod yn UUID dilys.',

    /*
    |--------------------------------------------------------------------------
    | Negeseuon Dilysu Personol
    |--------------------------------------------------------------------------
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Enwau Priodoleddau Personol
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'first_name' => 'enw cyntaf',
        'last_name' => 'cyfenw',
        'username' => 'enw defnyddiwr',
        'email' => 'e-bost',
        'profile_photo' => 'llun proffil',
        'bio' => 'bywgraffiad',
        'gender' => 'rhywedd',
        'date_of_birth' => 'dyddiad geni',
    ],

];