<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute doit être accepté.',
    'active_url' => ':attribute n\'est pas une URL valide.',
    'after' => ':attribute doit être une date après :date.',
    'after_or_equal' => ':attribute doit être une date après ou égale à :date.',
    'alpha' => ':attribute ne peut contenir que des lettres.',
    'alpha_dash' => ':attribute ne peut contenir que des lettres, des chiffres, des tirets et des underscores.',
    'alpha_num' => ':attribute ne peut contenir que des lettres et des chiffres.',
    'array' => ':attribute doit être un tableau.',
    'before' => ':attribute doit être une date avant :date.',
    'before_or_equal' => ':attribute doit être une date avant ou égale à :date.',
    'between' => [
        'numeric' => ':attribute doit être entre :min et :max.',
        'file' => ':attribute doit être entre :min et :max kilobytes.',
        'string' => ':attribute doit être entre :min et :max caractères.',
        'array' => ':attribute doit avoir entre :min et :max éléments.',
    ],
    'boolean' => ':attribute doit être true ou false.',
    'confirmed' => ':attribute confirmation ne correspond pas.',
    'date' => ':attribute n\'est pas une date valide.',
    'date_equals' => ':attribute doit être une date égale à :date.',
    'date_format' => ':attribute ne correspond pas au format :format.',
    'different' => ':attribute et :other doivent être différents.',
    'digits' => ':attribute doit être :digits chiffres.',
    'digits_between' => ':attribute doit être entre :min et :max chiffres.',
    'dimensions' => ':attribute a des dimensions d\'image invalides.',
    'distinct' => ':attribute doit être unique.',
    'email' => ':attribute doit être une adresse email valide.',
    'exists' => 'Le :attribute sélectionné est invalide.',
    'file' => ':attribute doit être un fichier.',
    'filled' => ':attribute doit avoir une valeur.',
    'gt' => [
        'numeric' => ':attribute doit être supérieur à :value.',
        'file' => ':attribute doit être supérieur à :value kilobytes.',
        'string' => ':attribute doit être supérieur à :value caractères.',
        'array' => ':attribute doit avoir plus de :value éléments.',
    ],
    'gte' => [
        'numeric' => ':attribute doit être supérieur ou égal à :value.',
        'file' => ':attribute doit être supérieur ou égal à :value kilobytes.',
        'string' => ':attribute doit être supérieur ou égal à :value caractères.',
        'array' => ':attribute doit avoir :value éléments ou plus.',
    ],
    'image' => ':attribute doit être une image.',
    'in' => 'Le :attribute sélectionné est invalide.',
    'in_array' => ':attribute n\'existe pas dans :other.',
    'integer' => ':attribute doit être un entier.',
    'ip' => ':attribute doit être une adresse IP valide.',
    'ipv4' => ':attribute doit être une adresse IPv4 valide.',
    'ipv6' => ':attribute doit être une adresse IPv6 valide.',
    'json' => ':attribute doit être une chaîne JSON valide.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => ':attribute doit être inférieur à :value kilobytes.',
        'string' => ':attribute doit être inférieur à :value caractères.',
        'array' => ':attribute doit avoir moins de :value éléments.',
    ],
    'lte' => [
        'numeric' => ':attribute doit être inférieur ou égal à :value.',
        'file' => ':attribute doit être inférieur ou égal à :value kilobytes.',
        'string' => ':attribute doit être inférieur ou égal à :value caractères.',
        'array' => ':attribute doit avoir moins de :value éléments.',
    ],
    'max' => [
        'numeric' => ':attribute ne doit pas être supérieur à :max.',
        'file' => ':attribute ne doit pas être supérieur à :max kilobytes.',
        'string' => ':attribute ne doit pas être supérieur à :max caractères.',
        'array' => ':attribute ne doit pas avoir plus de :max éléments.',
    ],
    'mimes' => ':attribute doit être un fichier de type: :values.',
    'mimetypes' => ':attribute doit être un fichier de type: :values.',
    'min' => [
        'numeric' => ':attribute doit être au moins :min.',
        'file' => ':attribute doit être au moins :min kilobytes.',
        'string' => ':attribute doit être au moins :min caractères.',
        'array' => ':attribute doit avoir au moins :min éléments.',
    ],
    'not_in' => 'Le :attribute sélectionné est invalide.',
    'not_regex' => ':attribute format est invalide.',
    'numeric' => ':attribute doit être un nombre.',
    'present' => ':attribute doit être présent.',
    'regex' => ':attribute format est invalide.',
    'required' => ':attribute doit être présent.',
    'required_if' => ':attribute doit être présent lorsque :other est :value.',
    'required_unless' => ':attribute doit être présent sauf lorsque :other est dans :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => ':attribute doit être présent lorsque :values sont présents.',
    'required_without' => ':attribute doit être présent lorsque :values n\'est pas présent.',
    'required_without_all' => ':attribute doit être présent lorsque aucun de :values n\'est présent.',
    'same' => ':attribute et :other doivent correspondre.',
    'size' => [
        'numeric' => ':attribute doit être :size.',
        'file' => ':attribute doit être :size kilobytes.',
        'string' => ':attribute doit être :size caractères.',
        'array' => ':attribute doit contenir :size éléments.',
    ],
    'starts_with' => ':attribute doit commencer par l\'un des suivants: :values',
    'string' => ':attribute doit être une chaîne de caractères.',
    'timezone' => ':attribute doit être une zone valide.',
    'unique' => ':attribute est déjà pris.',
    'uploaded' => ':attribute a échoué à télécharger.',
    'url' => ':attribute format est invalide.',
    'uuid' => ':attribute doit être un UUID valide.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
