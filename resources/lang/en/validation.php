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

	"accepted"             => ":attribute jābūt akceptētam",
	"active_url"           => ":attribute nav saites formātā",
	"after"                => ":attribute jābūt datumam pēc :date.",
	"alpha"                => ":attribute var saturēt tikai burtus.",
	"alpha_dash"           => ":attribute var saturēt tikai burtus, ciparus un simbolus",
	"alpha_num"            => ":attribute var saturēt tikai burtus un ciparus",
	"array"                => ":attribute jabūt masīvam",
	"before"               => ":attribute jābūt datumam pirms :date.",
	"between"              => [
		"numeric" => ":attribute jābūt starp :min un :max.",
		"file"    => ":attribute jābūt starp :min un :max kilobaitiem.",
		"string"  => ":attribute jābūt starp :min un :max simboliem.",
		"array"   => ":attribute jābūt starp :min un :max vietām.",
	],
	"boolean"              => ":attribute laukumam jābūt patiesam vai nepatiesam.",
	"confirmed"            => ":attribute apstiprinājums nav tāds pats.",
	"date"                 => ":attribute nav datuma formātā.",
	"date_format"          => ":attribute nav līdzīgs/tāds pats kā formāts :format.",
	"different"            => ":attribute un :other jābūt atšķirīgiem.",
	"digits"               => ":attribute jābūt :digits simboliem.",
	"digits_between"       => ":attribute jābūt starp :min un :max simboliem.",
	"email"                => ":attribute jābūt pieejamai e-pasta adresei.",
	"filled"               => ":attribute ir obligāts.",
	"exists"               => "izvēlētais :attribute ir nepieejams.",
	"image"                => ":attribute jabūt bildes formātā.",
	"in"                   => "izvēlētais :attribute ir nepieejams.",
	"integer"              => ":attribute jābūt skaitlim.",
	"ip"                   => ":attribute jābūt pieejamai Ip adresei.",
	"max"                  => [
		"numeric" => ":attribute nevar būt lielāks kā :max.",
		"file"    => ":attribute nevar būt lielāks kā :max kilobaiti.",
		"string"  => ":attribute nevar būt lielāks kā :max simboli.",
		"array"   => ":attribute nevar būt lielāks kā :max vietas.",
	],
	"mimes"                => ":attribute faila tipam jābūt: :values.",
	"min"                  => [
		"numeric" => ":attribute vajag būt vismaz :min.",
		"file"    => ":attribute vajag būt vismaz  :min kilobaiti.",
		"string"  => ":attribute vajag būt vismaz  :min simboli.",
		"array"   => ":attribute vajag būt vismaz  :min vietas.",
	],
	"not_in"               => "Izvēlētais :attribute ir nepieejams.",
	"numeric"              => ":attribute jābūt cipariem.",
	"regex"                => ":attribute formāts ir nepieejams.",
	"required"             => ":attribute lauks ir obligāts.",
	"required_if"          => ":attribute lauks ir obligāts, kad :other ir :value.",
	"required_with"        => ":attribute lauks ir obligāts, kad :values ir pieejams.",
	"required_with_all"    => ":attribute lauks ir obligāts, kad :values ir pieejams.",
	"required_without"     => ":attribute lauks ir obligāts, kad :values nav pieejams.",
	"required_without_all" => ":attribute lauks ir obligāts, kad :values nav manāms.",
	"same"                 => ":attribute un :other vajag sakrist.",
	"size"                 => [
		"numeric" => ":attribute vajag būt :size.",
		"file"    => ":attribute vajag būt :size kilobaitus.",
		"string"  => ":attribute vajag būt :size simbolis.",
		"array"   => ":attribute vajag saturēt :size vietas.",
	],
	"unique"               => ":attribute ir jau izmantots.",
	"url"                  => ":attribute formāts ir nepareiz.",
	"timezone"             => ":attribute vajag būt pieejamai laika zonai.",

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
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => [],

];
