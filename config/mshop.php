<?php

return array( 
	'popup' => array(
		'manager' => array(
			'lists' => array(
				'type' => array(
					'delete' => array(
						'ansi' => '
							DELETE FROM "mshop_popup_list_type"
							WHERE :cond AND siteid = ?
						'
					),
					'insert' => array(
						'ansi' => '
							INSERT INTO "mshop_popup_list_type"( :names
								"code", "domain", "label", "pos", "status",
								"mtime","editor", "siteid", "ctime"
							) VALUES ( :values
								?, ?, ?, ?, ?, ?, ?, ?, ?
							)
						'
					),
					'update' => array(
						'ansi' => '
							UPDATE "mshop_popup_list_type"
							SET :names
								"code" = ?, "domain" = ?, "label" = ?, "pos" = ?,
								"status" = ?, "mtime" = ?, "editor" = ?
							WHERE "siteid" = ? AND "id" = ?
						'
					),
					'search' => array(
						'ansi' => '
							SELECT :columns
								mattlity."id" AS "popup.lists.type.id", mattlity."siteid" AS "popup.lists.type.siteid",
								mattlity."code" AS "popup.lists.type.code", mattlity."domain" AS "popup.lists.type.domain",
								mattlity."label" AS "popup.lists.type.label", mattlity."status" AS "popup.lists.type.status",
								mattlity."mtime" AS "popup.lists.type.mtime", mattlity."ctime" AS "popup.lists.type.ctime",
								mattlity."editor" AS "popup.lists.type.editor", mattlity."pos" AS "popup.lists.type.position"
							FROM "mshop_popup_list_type" AS mattlity
							:joins
							WHERE :cond
							ORDER BY :order
							OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
						',
						'mysql' => '
							SELECT :columns
								mattlity."id" AS "popup.lists.type.id", mattlity."siteid" AS "popup.lists.type.siteid",
								mattlity."code" AS "popup.lists.type.code", mattlity."domain" AS "popup.lists.type.domain",
								mattlity."label" AS "popup.lists.type.label", mattlity."status" AS "popup.lists.type.status",
								mattlity."mtime" AS "popup.lists.type.mtime", mattlity."ctime" AS "popup.lists.type.ctime",
								mattlity."editor" AS "popup.lists.type.editor", mattlity."pos" AS "popup.lists.type.position"
							FROM "mshop_popup_list_type" AS mattlity
							:joins
							WHERE :cond
							ORDER BY :order
							LIMIT :size OFFSET :start
						'
					),
					'count' => array(
						'ansi' => '
							SELECT COUNT(*) AS "count"
							FROM (
								SELECT mattlity."id"
								FROM "mshop_popup_list_type" AS mattlity
								:joins
								WHERE :cond
								ORDER BY mattlity."id"
								OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
							) AS list
						',
						'mysql' => '
							SELECT COUNT(*) AS "count"
							FROM (
								SELECT mattlity."id"
								FROM "mshop_popup_list_type" AS mattlity
								:joins
								WHERE :cond
								ORDER BY mattlity."id"
								LIMIT 10000 OFFSET 0
							) AS list
						'
					),
					'newid' => array(
						'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
						'mysql' => 'SELECT LAST_INSERT_ID()',
						'oracle' => 'SELECT mshop_popup_list_type_seq.CURRVAL FROM DUAL',
						'pgsql' => 'SELECT lastval()',
						'sqlite' => 'SELECT last_insert_rowid()',
						'sqlsrv' => 'SELECT @@IDENTITY',
						'sqlanywhere' => 'SELECT @@IDENTITY',
					),
				),
				'aggregate' => array(
					'ansi' => '
						SELECT :keys, :type("val") AS "value"
						FROM (
							SELECT :acols, :val AS "val"
							FROM "mshop_popup_list" AS mattli
							:joins
							WHERE :cond
							GROUP BY :cols, mattli."id"
							ORDER BY :order
							OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
						) AS list
						GROUP BY :keys
					',
					'mysql' => '
						SELECT :keys, :type("val") AS "value"
						FROM (
							SELECT :acols, :val AS "val"
							FROM "mshop_popup_list" AS mattli
							:joins
							WHERE :cond
							GROUP BY :cols, mattli."id"
							ORDER BY :order
							LIMIT :size OFFSET :start
						) AS list
						GROUP BY :keys
					'
				),
				'delete' => array(
					'ansi' => '
						DELETE FROM "mshop_popup_list"
						WHERE :cond AND siteid = ?
					'
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "mshop_popup_list" ( :names
							"parentid", "key", "type", "domain", "refid", "start", "end",
							"config", "pos", "status", "mtime", "editor", "siteid", "ctime"
						) VALUES ( :values
							?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
						)
					'
				),
				'update' => array(
					'ansi' => '
						UPDATE "mshop_popup_list"
						SET :names
							"parentid" = ?, "key" = ?, "type" = ?, "domain" = ?, "refid" = ?, "start" = ?,
							"end" = ?, "config" = ?, "pos" = ?, "status" = ?, "mtime" = ?, "editor" = ?
						WHERE "siteid" = ? AND "id" = ?
					'
				),
				'search' => array(
					'ansi' => '
						SELECT :columns
							mattli."id" AS "popup.lists.id", mattli."siteid" AS "popup.lists.siteid",
							mattli."parentid" AS "popup.lists.parentid", mattli."type" AS "popup.lists.type",
							mattli."domain" AS "popup.lists.domain", mattli."refid" AS "popup.lists.refid",
							mattli."start" AS "popup.lists.datestart", mattli."end" AS "popup.lists.dateend",
							mattli."config" AS "popup.lists.config", mattli."pos" AS "popup.lists.position",
							mattli."status" AS "popup.lists.status", mattli."mtime" AS "popup.lists.mtime",
							mattli."ctime" AS "popup.lists.ctime", mattli."editor" AS "popup.lists.editor"
						FROM "mshop_popup_list" AS mattli
						:joins
						WHERE :cond
						ORDER BY :order
						OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
					',
					'mysql' => '
						SELECT :columns
							mattli."id" AS "popup.lists.id", mattli."siteid" AS "popup.lists.siteid",
							mattli."parentid" AS "popup.lists.parentid", mattli."type" AS "popup.lists.type",
							mattli."domain" AS "popup.lists.domain", mattli."refid" AS "popup.lists.refid",
							mattli."start" AS "popup.lists.datestart", mattli."end" AS "popup.lists.dateend",
							mattli."config" AS "popup.lists.config", mattli."pos" AS "popup.lists.position",
							mattli."status" AS "popup.lists.status", mattli."mtime" AS "popup.lists.mtime",
							mattli."ctime" AS "popup.lists.ctime", mattli."editor" AS "popup.lists.editor"
						FROM "mshop_popup_list" AS mattli
						:joins
						WHERE :cond
						ORDER BY :order
						LIMIT :size OFFSET :start
					'
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mattli."id"
							FROM "mshop_popup_list" AS mattli
							:joins
							WHERE :cond
							ORDER BY mattli."id"
							OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
						) AS list
					',
					'mysql' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mattli."id"
							FROM "mshop_popup_list" AS mattli
							:joins
							WHERE :cond
							ORDER BY mattli."id"
							LIMIT 10000 OFFSET 0
						) AS list
					'
				),
				'newid' => array(
					'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
					'mysql' => 'SELECT LAST_INSERT_ID()',
					'oracle' => 'SELECT mshop_popup_list_seq.CURRVAL FROM DUAL',
					'pgsql' => 'SELECT lastval()',
					'sqlite' => 'SELECT last_insert_rowid()',
					'sqlsrv' => 'SELECT @@IDENTITY',
					'sqlanywhere' => 'SELECT @@IDENTITY',
				),
			),
			'property' => array(
				'type' => array(
					'delete' => array(
						'ansi' => '
							DELETE FROM "mshop_popup_property_type"
							WHERE :cond AND siteid = ?
						'
					),
					'insert' => array(
						'ansi' => '
							INSERT INTO "mshop_popup_property_type" ( :names
								"code", "domain", "label", "pos", "status",
								"mtime", "editor", "siteid", "ctime"
							) VALUES ( :values
								?, ?, ?, ?, ?, ?, ?, ?, ?
							)
						'
					),
					'update' => array(
						'ansi' => '
							UPDATE "mshop_popup_property_type"
							SET :names
								"code" = ?, "domain" = ?, "label" = ?, "pos" = ?,
								"status" = ?, "mtime" = ?, "editor" = ?
							WHERE "siteid" = ? AND "id" = ?
						'
					),
					'search' => array(
						'ansi' => '
							SELECT :columns
								mattprty."id" AS "popup.property.type.id", mattprty."siteid" AS "popup.property.type.siteid",
								mattprty."code" AS "popup.property.type.code", mattprty."domain" AS "popup.property.type.domain",
								mattprty."label" AS "popup.property.type.label", mattprty."status" AS "popup.property.type.status",
								mattprty."mtime" AS "popup.property.type.mtime", mattprty."editor" AS "popup.property.type.editor",
								mattprty."ctime" AS "popup.property.type.ctime", mattprty."pos" AS "popup.property.type.position"
							FROM "mshop_popup_property_type" mattprty
							:joins
							WHERE :cond
							ORDER BY :order
							OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
						',
						'mysql' => '
							SELECT :columns
								mattprty."id" AS "popup.property.type.id", mattprty."siteid" AS "popup.property.type.siteid",
								mattprty."code" AS "popup.property.type.code", mattprty."domain" AS "popup.property.type.domain",
								mattprty."label" AS "popup.property.type.label", mattprty."status" AS "popup.property.type.status",
								mattprty."mtime" AS "popup.property.type.mtime", mattprty."editor" AS "popup.property.type.editor",
								mattprty."ctime" AS "popup.property.type.ctime", mattprty."pos" AS "popup.property.type.position"
							FROM "mshop_popup_property_type" mattprty
							:joins
							WHERE :cond
							ORDER BY :order
							LIMIT :size OFFSET :start
						'
					),
					'count' => array(
						'ansi' => '
							SELECT COUNT(*) AS "count"
							FROM (
								SELECT mattprty."id"
								FROM "mshop_popup_property_type" mattprty
								:joins
								WHERE :cond
								ORDER BY mattprty."id"
								OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
							) AS list
						',
						'mysql' => '
							SELECT COUNT(*) AS "count"
							FROM (
								SELECT mattprty."id"
								FROM "mshop_popup_property_type" mattprty
								:joins
								WHERE :cond
								ORDER BY mattprty."id"
								LIMIT 10000 OFFSET 0
							) AS list
						'
					),
					'newid' => array(
						'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
						'mysql' => 'SELECT LAST_INSERT_ID()',
						'oracle' => 'SELECT mshop_popup_property_type_seq.CURRVAL FROM DUAL',
						'pgsql' => 'SELECT lastval()',
						'sqlite' => 'SELECT last_insert_rowid()',
						'sqlsrv' => 'SELECT @@IDENTITY',
						'sqlanywhere' => 'SELECT @@IDENTITY',
					),
				),
				'delete' => array(
					'ansi' => '
						DELETE FROM "mshop_popup_property"
						WHERE :cond AND siteid = ?
					'
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "mshop_popup_property" ( :names
							"parentid", "key", "type", "langid", "value",
							"mtime", "editor", "siteid", "ctime"
						) VALUES ( :values
							?, ?, ?, ?, ?, ?, ?, ?, ?
						)
					'
				),
				'update' => array(
					'ansi' => '
						UPDATE "mshop_popup_property"
						SET :names
							"parentid" = ?, "key" = ?, "type" = ?, "langid" = ?,
							"value" = ?, "mtime" = ?, "editor" = ?
						WHERE "siteid" = ? AND "id" = ?
					'
				),
				'search' => array(
					'ansi' => '
						SELECT :columns
							mattpr."id" AS "popup.property.id", mattpr."parentid" AS "popup.property.parentid",
							mattpr."siteid" AS "popup.property.siteid", mattpr."type" AS "popup.property.type",
							mattpr."langid" AS "popup.property.languageid", mattpr."value" AS "popup.property.value",
							mattpr."mtime" AS "popup.property.mtime", mattpr."editor" AS "popup.property.editor",
							mattpr."ctime" AS "popup.property.ctime"
						FROM "mshop_popup_property" AS mattpr
						:joins
						WHERE :cond
						ORDER BY :order
						OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
					',
					'mysql' => '
						SELECT :columns
							mattpr."id" AS "popup.property.id", mattpr."parentid" AS "popup.property.parentid",
							mattpr."siteid" AS "popup.property.siteid", mattpr."type" AS "popup.property.type",
							mattpr."langid" AS "popup.property.languageid", mattpr."value" AS "popup.property.value",
							mattpr."mtime" AS "popup.property.mtime", mattpr."editor" AS "popup.property.editor",
							mattpr."ctime" AS "popup.property.ctime"
						FROM "mshop_popup_property" AS mattpr
						:joins
						WHERE :cond
						ORDER BY :order
						LIMIT :size OFFSET :start
					'
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mattpr."id"
							FROM "mshop_popup_property" AS mattpr
							:joins
							WHERE :cond
							ORDER BY mattpr."id"
							OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
						) AS list
					',
					'mysql' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mattpr."id"
							FROM "mshop_popup_property" AS mattpr
							:joins
							WHERE :cond
							ORDER BY mattpr."id"
							LIMIT 10000 OFFSET 0
						) AS list
					'
				),
				'newid' => array(
					'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
					'mysql' => 'SELECT LAST_INSERT_ID()',
					'oracle' => 'SELECT mshop_popup_property_seq.CURRVAL FROM DUAL',
					'pgsql' => 'SELECT lastval()',
					'sqlite' => 'SELECT last_insert_rowid()',
					'sqlsrv' => 'SELECT @@IDENTITY',
					'sqlanywhere' => 'SELECT @@IDENTITY',
				),
			),
			'type' => array(
				'delete' => array(
					'ansi' => '
						DELETE FROM "mshop_popup_type"
						WHERE :cond AND siteid = ?
					'
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "mshop_popup_type" ( :names
							"code", "domain", "label", "pos", "status",
							"mtime", "editor", "siteid", "ctime"
						) VALUES ( :values
							?, ?, ?, ?, ?, ?, ?, ?, ?
						)
					'
				),
				'update' => array(
					'ansi' => '
						UPDATE "mshop_popup_type"
						SET :names
							"code" = ?, "domain" = ?, "label" = ?, "pos" = ?,
							"status" = ?, "mtime" = ?, "editor" = ?
						WHERE "siteid" = ? AND "id" = ?
					'
				),
				'search' => array(
					'ansi' => '
						SELECT :columns
							mattty."id" AS "popup.type.id", mattty."siteid" AS "popup.type.siteid",
							mattty."code" AS "popup.type.code", mattty."domain" AS "popup.type.domain",
							mattty."label" AS "popup.type.label", mattty."status" AS "popup.type.status",
							mattty."mtime" AS "popup.type.mtime", mattty."ctime" AS "popup.type.ctime",
							mattty."editor" AS "popup.type.editor", mattty."pos" AS "popup.type.position"
						FROM "mshop_popup_type" AS mattty
						:joins
						WHERE :cond
						ORDER BY :order
						OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
					',
					'mysql' => '
						SELECT :columns
							mattty."id" AS "popup.type.id", mattty."siteid" AS "popup.type.siteid",
							mattty."code" AS "popup.type.code", mattty."domain" AS "popup.type.domain",
							mattty."label" AS "popup.type.label", mattty."status" AS "popup.type.status",
							mattty."mtime" AS "popup.type.mtime", mattty."ctime" AS "popup.type.ctime",
							mattty."editor" AS "popup.type.editor", mattty."pos" AS "popup.type.position"
						FROM "mshop_popup_type" AS mattty
						:joins
						WHERE :cond
						ORDER BY :order
						LIMIT :size OFFSET :start
					'
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mattty."id"
							FROM "mshop_popup_type" AS mattty
							:joins
							WHERE :cond
							ORDER BY mattty."id"
							OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
						) AS list
					',
					'mysql' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mattty."id"
							FROM "mshop_popup_type" AS mattty
							:joins
							WHERE :cond
							ORDER BY mattty."id"
							LIMIT 10000 OFFSET 0
						) AS list
					'
				),
				'newid' => array(
					'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
					'mysql' => 'SELECT LAST_INSERT_ID()',
					'oracle' => 'SELECT mshop_popup_type_seq.CURRVAL FROM DUAL',
					'pgsql' => 'SELECT lastval()',
					'sqlite' => 'SELECT last_insert_rowid()',
					'sqlsrv' => 'SELECT @@IDENTITY',
					'sqlanywhere' => 'SELECT @@IDENTITY',
				),
			),
			'delete' => array(
				'ansi' => '
					DELETE FROM "mshop_popup"
					WHERE :cond AND siteid = ?
				'
			),
			'insert' => array(
				'ansi' => '
					INSERT INTO "mshop_popup" ( :names
						"key", "type", "domain", "code", "status", "pos",
						"label", "mtime", "editor", "siteid", "ctime"
					) VALUES ( :values
						?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
					)
				'
			),
			'update' => array(
				'ansi' => '
					UPDATE "mshop_popup"
					SET :names
						"key" = ?, "type" = ?, "domain" = ?, "code" = ?, "status" = ?,
						"pos" = ?, "label" = ?, "mtime" = ?, "editor" = ?
					WHERE "siteid" = ? AND "id" = ?
				'
			),
			'search' => array(
				'ansi' => '
					SELECT :columns
						matt."id" AS "popup.id", matt."siteid" AS "popup.siteid",
						matt."type" AS "popup.type", matt."domain" AS "popup.domain",
						matt."code" AS "popup.code", matt."status" AS "popup.status",
						matt."pos" AS "popup.position", matt."label" AS "popup.label",
						matt."mtime" AS "popup.mtime", matt."ctime" AS "popup.ctime",
						matt."editor" AS "popup.editor"
					FROM "mshop_popup" AS matt
					:joins
					WHERE :cond
					GROUP BY :columns :group
						matt."id", matt."siteid", matt."type", matt."domain", matt."code", matt."status",
						matt."pos", matt."label", matt."mtime", matt."ctime", matt."editor"
					ORDER BY :order
					OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
				',
				'mysql' => '
					SELECT :columns
						matt."id" AS "popup.id", matt."siteid" AS "popup.siteid",
						matt."type" AS "popup.type", matt."domain" AS "popup.domain",
						matt."code" AS "popup.code", matt."status" AS "popup.status",
						matt."pos" AS "popup.position", matt."label" AS "popup.label",
						matt."mtime" AS "popup.mtime", matt."ctime" AS "popup.ctime",
						matt."editor" AS "popup.editor"
					FROM "mshop_popup" AS matt
					:joins
					WHERE :cond
					GROUP BY :group matt."id"
					ORDER BY :order
					LIMIT :size OFFSET :start
				'
			),
			'count' => array(
				'ansi' => '
					SELECT COUNT(*) AS "count"
					FROM (
						SELECT matt."id"
						FROM "mshop_popup" AS matt
						:joins
						WHERE :cond
						GROUP BY matt."id"
						ORDER BY matt."id"
						OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
					) AS list
				',
				'mysql' => '
					SELECT COUNT(*) AS "count"
					FROM (
						SELECT matt."id"
						FROM "mshop_popup" AS matt
						:joins
						WHERE :cond
						GROUP BY matt."id"
						ORDER BY matt."id"
						LIMIT 10000 OFFSET 0
					) AS list
				'
			),
			'newid' => array(
				'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
				'mysql' => 'SELECT LAST_INSERT_ID()',
				'oracle' => 'SELECT mshop_popup_seq.CURRVAL FROM DUAL',
				'pgsql' => 'SELECT lastval()',
				'sqlite' => 'SELECT last_insert_rowid()',
				'sqlsrv' => 'SELECT @@IDENTITY',
				'sqlanywhere' => 'SELECT @@IDENTITY',
			),
		),
),
	
);
