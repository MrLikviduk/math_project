// Configuration
var _wrs_conf_editorEnabled = true;		// Specifies if fomula editor is enabled.
var _wrs_conf_CASEnabled = true;		// Specifies if WIRIS cas is enabled.

var _wrs_conf_imageMathmlAttribute = 'data-mathml';	// Specifies the image tag where we should save the formula editor mathml code.
var _wrs_conf_CASMathmlAttribute = 'alt';	// Specifies the image tag where we should save the WIRIS cas mathml code.

var _wrs_conf_imageClassName = 'Wirisformula';		// Specifies the class name for WIRIS formulas.
var _wrs_conf_CASClassName = 'Wiriscas';			// Specifies the class name for WIRIS CAS objects.

var _wrs_conf_editorPath = _wrs_currentPath + nicedit_wiris_path + '/integration/editor.php';			// Specifies where is the editor HTML code (for popup window).
var _wrs_conf_editorAttributes = 'width=570, height=450, scroll=no, resizable=yes';							// Specifies formula editor window options.
var _wrs_conf_CASPath = _wrs_currentPath + nicedit_wiris_path + '/integration/cas.php';					// Specifies where is the WIRIS cas HTML code (for popup window).
var _wrs_conf_CASAttributes = 'width=640, height=480, scroll=no, resizable=yes';							// Specifies WIRIS cas window options.

var _wrs_conf_createimagePath = _wrs_currentPath + nicedit_wiris_path + '/integration/createimage.php';			// Specifies where is createimage script.
var _wrs_conf_createcasimagePath = _wrs_currentPath + nicedit_wiris_path + '/integration/createcasimage.php';	// Specifies where is createcasimage script.

var _wrs_conf_getmathmlPath = _wrs_currentPath + nicedit_wiris_path + '/integration/getmathml.php';			// Specifies where is the getmathml script.
var _wrs_conf_servicePath = _wrs_currentPath + nicedit_wiris_path + '/integration/service.php';			// Specifies where is the service script.

var _wrs_conf_saveMode = 'tags';					// This value can be 'tags', 'xml' or 'safeXml'.
var _wrs_conf_parseModes = ['latex'];				// This value can contain 'latex'.

var _wrs_conf_enableAccessibility = true;

// Vars
var _wrs_int_editorIcon = _wrs_currentPath + nicedit_wiris_path + '/core/icons/formula.gif';
var _wrs_int_CASIcon = _wrs_currentPath + nicedit_wiris_path + '/core/icons/cas.gif';
var _wrs_int_temporalElement;
var _wrs_int_temporalElementIsIframe;
var _wrs_int_window;
var _wrs_int_window_opened = false;
var _wrs_int_temporalImageResizing;
var _wrs_int_language = 'en';
var _wrs_int_wirisProperties;
var _wrs_int_wirisProperties = '';

// Plugin integration

var buttons = {};
var icons = {};

if (_wrs_conf_editorEnabled) {
	buttons['nicedit_wiris_editor'] = {
		'name': 'WIRIS editor',
		'type': 'nicedit_wiris_editorButton'
	};
	
	icons['nicedit_wiris_editor'] = _wrs_int_editorIcon;
}

if (_wrs_conf_CASEnabled) {
	buttons['nicedit_wiris_cas'] = {
		'name': 'WIRIS CAS',
		'type': 'nicedit_wiris_casButton'
	};
	
	icons['nicedit_wiris_cas'] = _wrs_int_CASIcon;
}

var nicedit_wiris_options = {
	'buttons': buttons,
	'iconFiles': icons
};

var nicedit_wiris_editorButton = nicEditorButton.extend({
	'init': function () {
		wrs_int_setUpEditorInstance();
		var self = this;
		
		wrs_int_fixButton(this, function () {
			var isIframe = (self.ne.selectedInstance instanceof nicEditorIFrameInstance);
			wrs_int_openNewFormulaEditor(self.ne.selectedInstance.getElm(), isIframe, _wrs_int_language);
		});

		_wrs_int_wirisProperties = {};
		if ('wirisimagecolor' in self.ne.options) {
			_wrs_int_wirisProperties['color'] = self.ne.options['wirisimagecolor'];
		}

		if ('wirisimagebgcolor' in self.ne.options) {
			_wrs_int_wirisProperties['bgColor'] = self.ne.options['wirisimagebgcolor'];
		}

		if ('wirisimagebackgroundcolor' in self.ne.options) {
			_wrs_int_wirisProperties['backgroundColor'] = self.ne.options['wirisimagebackgroundcolor'];
		}

		if ('wirisimagesymbolcolor' in self.ne.options) {
			_wrs_int_wirisProperties['symbolColor'] = self.ne.options['wirisimagesymbolcolor'];
		}

		if ('wirisimagenumbercolor' in self.ne.options) {
			_wrs_int_wirisProperties['numberColor'] = self.ne.options['wirisimagenumbercolor'];
		}

		if ('wirisimageidentcolor' in self.ne.options) {
			_wrs_int_wirisProperties['identColor'] = self.ne.options['wirisimageidentcolor'];
		}

		if ('wiristransparency' in self.ne.options) {
			_wrs_int_wirisProperties['transparency'] = self.ne.options['wiristransparency'];
		}

		if ('wirisimagefontsize' in self.ne.options) {
			_wrs_int_wirisProperties['fontSize'] = self.ne.options['wirisimagefontsize'];
		}

		if ('wirisdpi' in self.ne.options) {
			_wrs_int_wirisProperties['dpi'] = self.ne.options['wirisdpi'];
		}
		
	}
});

var nicedit_wiris_casButton = nicEditorButton.extend({
	'init': function () {
		wrs_int_setUpEditorInstance();
		var self = this;
		
		wrs_int_fixButton(this, function () {
			var isIframe = (self.ne.selectedInstance instanceof nicEditorIFrameInstance);
			wrs_int_openNewCAS(self.ne.selectedInstance.getElm(), isIframe, _wrs_int_language);
		});
	}
});

nicEditors.registerPlugin(nicPlugin, nicedit_wiris_options);

/**
 * Handles a double click.
 * @param object target Target
 * @param object element Element double clicked
 */
function wrs_int_doubleClickHandler(target, isIframe, element) {
	if (element.nodeName.toLowerCase() == 'img') {
		if (wrs_containsClass(element, _wrs_conf_imageClassName)) {
			if (!_wrs_int_window_opened) {
				_wrs_temporalImage = element;
				wrs_int_openExistingFormulaEditor(target, isIframe, _wrs_int_language);
			}
			else {
				_wrs_int_window.focus();
			}
		}
		else if (wrs_containsClass(element, _wrs_conf_CASClassName)) {
			if (!_wrs_int_window_opened) {
				_wrs_temporalImage = element;
				wrs_int_openExistingCAS(target, isIframe, _wrs_int_language);
			}
			else {
				_wrs_int_window.focus();
			}
		}
	}
}

/**
 * Handles a double click on the contentEditable div.
 * @param object div Target
 * @param object element Element double clicked
 */
function wrs_int_doubleClickHandlerForDiv(div, element) {
	wrs_int_doubleClickHandler(div, false, element);
}

/**
 * Handles a double click on the iframe.
 * @param object div Target
 * @param object element Element double clicked
 */
function wrs_int_doubleClickHandlerForIframe(iframe, element) {
	wrs_int_doubleClickHandler(iframe, true, element);
}

/**
 * Creates a button based on an A element in order to avoid the pop-up block.
 * @param nicEditorButton originalButton The original button
 */
function wrs_int_fixButton(originalButton, clickHandler) {
	var realButton = document.createElement('a');
	realButton.style.display = 'block';
	realButton.style.background = originalButton.button.style.backgroundImage + ' center center no-repeat';
	realButton.style.height = originalButton.button.style.height;
	realButton.style.width = originalButton.button.style.width;
	realButton.href = 'javascript:;';
	
	wrs_addEvent(realButton, 'click', clickHandler);
	
	originalButton.button.style.background = 'transparent';
	originalButton.button.appendChild(realButton);
}

/**
 * Handles a mouse down event.
 * @param object target Target
 * @param object element Element mouse downed
 */
function wrs_int_mousedownHandler(target, element) {
	if (element.nodeName.toLowerCase() == 'img') {
		if (wrs_containsClass(element, _wrs_conf_imageClassName) || wrs_containsClass(element, _wrs_conf_CASClassName)) {
			_wrs_int_temporalImageResizing = element;
		}
	}
}

/**
 * Handles a mouse up event on the iframe.
 */
function wrs_int_mouseupHandler() {
	if (_wrs_int_temporalImageResizing) {
		setTimeout(function () {
			_wrs_int_temporalImageResizing.removeAttribute('style');
			_wrs_int_temporalImageResizing.removeAttribute('width');
			_wrs_int_temporalImageResizing.removeAttribute('height');
		}, 10);
	}
}

/**
 * Handles window closing.
 */
function wrs_int_notifyWindowClosed() {
	_wrs_int_window_opened = false;
}

/**
 * Opens CAS to edit an existing formula.
 * @param object iframe Target
 */
function wrs_int_openExistingCAS(element, isIframe, language) {
	_wrs_int_window_opened = true;
	_wrs_isNewElement = false;
	_wrs_int_temporalElement = element;
	_wrs_int_temporalElementIsIframe = isIframe;
	_wrs_int_window = wrs_openCASWindow(element, isIframe, language);
}

/**
 * Opens formula editor to edit an existing formula.
 * @param object element Target
 * @param boolean isIframe
 */
function wrs_int_openExistingFormulaEditor(element, isIframe, language) {
	_wrs_int_window_opened = true;
	_wrs_isNewElement = false;
	_wrs_int_temporalElement = element;
	_wrs_int_temporalElementIsIframe = isIframe;
	_wrs_int_window = wrs_openEditorWindow(language, element, isIframe);
}

/**
 * Opens CAS.
 * @param object element Target
 * @param boolean isIframe Specifies if the element is an iframe.
 */
function wrs_int_openNewCAS(element, isIframe, language) {
	if (_wrs_int_window_opened) {
		_wrs_int_window.focus();
	}
	else {
		_wrs_int_window_opened = true;
		_wrs_isNewElement = true;
		_wrs_int_temporalElement = element;
		_wrs_int_temporalElementIsIframe = isIframe;
		_wrs_int_window = wrs_openCASWindow(element, isIframe, language);
	}
}

/**
 * Opens formula editor.
 * @param object element Target
 * @param boolean isIframe Specifies if the element is an iframe.
 */
function wrs_int_openNewFormulaEditor(element, isIframe, language) {
	if (_wrs_int_window_opened) {
		_wrs_int_window.focus();
	}
	else {
		_wrs_int_window_opened = true;
		_wrs_isNewElement = true;
		_wrs_int_temporalElement = element;
		_wrs_int_temporalElementIsIframe = isIframe;
		_wrs_int_window = wrs_openEditorWindow(language, element, isIframe);
	}
}

/**
 * Sets up the nicEditorInstance in order to use wrs_initParse at the initialization of each editor.
 */
function wrs_int_setUpEditorInstance() {
	if (nicEditorInstance.wrs_initApplied === undefined) {
		nicEditorInstance.wrs_initApplied = true;
		
		// Init.
		nicEditorInstance.prototype.wrs_originalInit = nicEditorInstance.prototype.init;
		nicEditorIFrameInstance.prototype.wrs_originalInit = nicEditorIFrameInstance.prototype.init;
		
		var newInit = function () {
			this.wrs_originalInit();
			this.setContent(wrs_initParse(wrs_getInnerHTML(this.getElm()), _wrs_int_language));
			
			if (this instanceof nicEditorIFrameInstance) {
				wrs_addIframeEvents(this.getElm(), wrs_int_doubleClickHandlerForIframe, wrs_int_mousedownHandler, wrs_int_mouseupHandler);
			}
			else {
				wrs_addElementEvents(this.getElm(), wrs_int_doubleClickHandlerForDiv, wrs_int_mousedownHandler, wrs_int_mouseupHandler);
			}
		};
		
		nicEditorInstance.prototype.init = newInit;
		nicEditorIFrameInstance.prototype.init = newInit;
		
		// End.
		nicEditorInstance.prototype.wrs_originalSaveContent = nicEditorInstance.prototype.saveContent;
		
		nicEditorInstance.prototype.saveContent = function () {
			this.wrs_originalSaveContent();
			this.copyElm.value = wrs_endParse(this.copyElm.value, null, _wrs_int_language);
		};
	}
}

/**
 * Calls wrs_updateFormula with well params.
 * @param string mathml
 */
function wrs_int_updateFormula(mathml, editMode, language) {
	if (_wrs_int_temporalElementIsIframe) {
		wrs_updateFormula(_wrs_int_temporalElement.contentWindow, _wrs_int_temporalElement.contentWindow, mathml, _wrs_int_wirisProperties, editMode, language);
	}
	else {
		wrs_updateFormula(_wrs_int_temporalElement, window, mathml, _wrs_int_wirisProperties, editMode, language);
	}
}

/**
 * Calls wrs_updateCAS with well params.
 * @param string appletCode
 * @param string image
 * @param int width
 * @param int height
 */
function wrs_int_updateCAS(appletCode, image, width, height) {
	if (_wrs_int_temporalElementIsIframe) {
		wrs_updateCAS(_wrs_int_temporalElement.contentWindow, _wrs_int_temporalElement.contentWindow, appletCode, image, width, height);
	}
	else {
		wrs_updateCAS(_wrs_int_temporalElement, window, appletCode, image, width, height);
	}
}
