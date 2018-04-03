<style type="text/css">
	.form { margin-top: 30px; }
	.form label { font-weight: bold; display: block; margin: 0 0 5px; }
	.form .formfield { margin: 0 0 20px;  }
	.form .input { height: 30px; padding: 0 10px; width: 100%; }
	.form textarea { height: 120px; padding: 5px 10px; width: 100%; }
	.form .cols { overflow: hidden; }
	.form .cols .col { float: left; width: 49%; margin: 0px 2% 20px 0px; }
	.form .cols .col.bordered { box-sizing: border-box; border: 1px solid #aaa; padding: 20px; }
	.form .cols .col:last-child, .form .cols .col:nth-child(2n) { margin-right: 0; }
	.form .cols .col:nth-child(2n+1) { clear: both; }

	.form .upload img, .form .upload .update-image-button, .form .upload .remove-image-button, .form .upload .size-warning { display: none; }
	.form .upload img { max-width: 100%; max-height: 150px; vertical-align: middle; }
	.form .upload.active .add-image-button { display: none; }
	.form .upload.active .update-image-button, .form .upload.active .remove-image-button { display: inline-block; }
	.form .upload.active img { display: block; }
	.form .upload.active .size-warning { display: block; font-weight: bold; color: #ff0000; margin: 5px 0px; }
	
	.form .triggerable .triggerable-button { margin-bottom: 10px; }
	.form .triggerable .triggerable-content,
	.form .triggerable .triggerable-button .hide,
	.form .triggerable.active .triggerable-button .show { display: none; }
	.form .triggerable.active .triggerable-button .hide { display: inline-block; }
	.form .triggerable.active .triggerable-content { display: block; }

	.form .preview-box { background: #fff; width: 100%; min-height: 50px; max-width: 728px; }
	.form .preview-box table { max-width: 100%; }
	.form .preview-box table img { max-width: 100%; }
	.form .preview-box table td { width: 50%; }
	.form .preview-box ul { list-style-type: disc; padding-left: 30px; margin: 20px 0px; }

	#wpfooter { display: none !important; }


	#wp-link-wrap .query-results,
	.mce-checkbox i.mce-i-checkbox,
	.mce-textbox {
	    border: 1px solid #ddd;
	    -webkit-border-radius: 0;
	    border-radius: 0;
	    -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, .07);
	    box-shadow: inset 0 1px 2px rgba(0, 0, 0, .07);
	    -webkit-transition: .05s all ease-in-out;
	    transition: .05s all ease-in-out
	}

	#wp-link-wrap .query-results:focus,
	.mce-checkbox:focus i.mce-i-checkbox,
	.mce-textbox.mce-focus,
	.mce-textbox:focus {
	    border-color: #5b9dd9;
	    -webkit-box-shadow: 0 0 2px rgba(30, 140, 190, .8);
	    box-shadow: 0 0 2px rgba(30, 140, 190, .8)
	}

	#wp-link-wrap {
	    display: none;
	    background-color: #fff;
	    box-shadow: 0 3px 6px rgba(0, 0, 0, .3);
	    width: 500px;
	    overflow: hidden;
	    margin-left: -250px;
	    position: fixed;
	    top: 50%;
	    left: 50%;
	    z-index: 100105;
	    -webkit-transition: height .2s, margin-top .2s;
	    transition: height .2s, margin-top .2s;
	    height: 500px;
	    margin-top: -250px
	}

	#wp-link-wrap {
	    position: relative;
	    height: 100%
	}

	#wp-link-wrap .wp-link-text-field {
	    display: none
	}

	#wp-link-wrap.has-text-field .wp-link-text-field {
	    display: block
	}

	#wp-link-wrap #link-selector {
	    -webkit-overflow-scrolling: touch;
	    padding: 0 16px;
	    position: absolute;
	    top: 37px;
	    left: 0;
	    right: 0;
	    bottom: 44px
	}

	#wp-link-wrap ol,
	#wp-link-wrap ul {
	    list-style: none;
	    margin: 0;
	    padding: 0
	}

	#wp-link-wrap input[type=text] {
	    -webkit-box-sizing: border-box;
	    -moz-box-sizing: border-box;
	    box-sizing: border-box
	}

	#wp-link-wrap #link-options {
	    padding: 8px 0 12px
	}

	#wp-link-wrap p.howto {
	    margin: 3px 0
	}

	#wp-link-wrap p.howto a {
	    text-decoration: none;
	    color: inherit
	}

	#wp-link-wrap label input[type=text] {
	    margin-top: 5px;
	    width: 70%
	}

	#wp-link-wrap #link-options label span,
	#wp-link-wrap #search-panel label span.search-label {
	    display: inline-block;
	    width: 80px;
	    text-align: right;
	    padding-right: 5px;
	    max-width: 24%;
	    vertical-align: middle;
	    word-wrap: break-word
	}

	#wp-link-wrap .link-search-field {
	    float: left;
	    width: 250px;
	    max-width: 70%
	}

	#wp-link-wrap .link-search-wrapper {
	    margin: 5px 0 9px;
	    display: block;
	    overflow: hidden
	}

	#wp-link-wrap .link-search-wrapper span {
	    float: left;
	    margin-top: 4px
	}

	#wp-link-wrap .link-search-wrapper .spinner {
	    margin-top: 5px
	}

	#wp-link-wrap .link-target {
	    padding: 3px 0 0;
	    white-space: nowrap;
	    overflow: hidden;
	    text-overflow: ellipsis
	}

	#wp-link-wrap .link-target label {
	    max-width: 70%
	}

	#wp-link-wrap .query-results {
	    border: 1px solid #dfdfdf;
	    margin: 0 0 12px;
	    background: #fff;
	    overflow: auto;
	    position: absolute;
	    left: 16px;
	    right: 16px;
	    bottom: 0;
	    top: 166px
	}

	.has-text-field #wp-link-wrap .query-results {
	    top: 200px
	}

	#wp-link-wrap li {
	    clear: both;
	    margin-bottom: 0;
	    border-bottom: 1px solid #f1f1f1;
	    color: #32373c;
	    padding: 4px 6px 4px 10px;
	    cursor: pointer;
	    position: relative
	}

	#wp-link-wrap .query-notice,
	#wp-link-wrap li.unselectable {
	    border-bottom: 1px solid #dfdfdf
	}

	#wp-link-wrap .query-notice {
	    padding: 0;
	    background-color: #f7fcfe;
	    color: #000
	}

	#wp-link-wrap .query-notice .query-notice-default,
	#wp-link-wrap .query-notice .query-notice-hint {
	    display: block;
	    padding: 6px;
	    border-left: 4px solid #00a0d2
	}

	#wp-link-wrap .unselectable.no-matches-found {
	    padding: 0;
	    border-bottom: 1px solid #dfdfdf;
	    background-color: #fef7f1
	}

	#wp-link-wrap .no-matches-found .item-title {
	    display: block;
	    padding: 6px;
	    border-left: 4px solid #d54e21
	}

	#wp-link-wrap .query-results em {
	    font-style: normal
	}

	#wp-link-wrap li:hover {
	    background: #eaf2fa;
	    color: #151515
	}

	#wp-link-wrap li.unselectable:hover {
	    background: #fff;
	    cursor: auto;
	    color: #32373c
	}

	#wp-link-wrap li.selected {
	    background: #ddd;
	    color: #32373c
	}

	#wp-link-wrap li.selected .item-title {
	    font-weight: 600
	}

	#wp-link-wrap li:last-child {
	    border: none
	}

	#wp-link-wrap .item-title {
	    display: inline-block;
	    width: 80%;
	    width: -webkit-calc(100% - 68px);
	    width: calc(100% - 68px);
	    word-wrap: break-word
	}

	#wp-link-wrap .item-info {
	    text-transform: uppercase;
	    color: #666;
	    font-size: 11px;
	    position: absolute;
	    right: 5px;
	    top: 5px
	}

	#wp-link-wrap .river-waiting {
	    display: none;
	    padding: 10px 0
	}

	#wp-link-wrap .submitbox {
	    padding: 8px 16px;
	    background: #fcfcfc;
	    border-top: 1px solid #ddd;
	    position: absolute;
	    bottom: 0;
	    left: 0;
	    right: 0
	}
	#wp-link-wrap #most-recent-results { top: 190px; }
</style>

<!--

PA: #69b42e
IA: #0095db
FSA: #e40233
EI: #f9ae00

-->
