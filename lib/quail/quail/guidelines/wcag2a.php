<?php 
/**
*    QUAIL - QUAIL Accessibility Information Library
*    Copyright (C) 2009 Kevin Miller
*
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*	@author Kevin Miller <kemiller@csumb.edu>
*/

/** \addtogroup guidelines */
/*@{*/

/**
*	WCAG 2.0 Level A Guideline
*/
class Wcag2aGuideline extends quailGuideline{

	/**
	*	@var array An array of test class names which will be called for this guideline
	*/	
	var $tests = array(
		'imgHasAlt',
		'imgAltIsDifferent',
		'imgAltIsTooLong',
		'imgAltNotPlaceHolder',
		'imgAltNotEmptyInAnchor',
		'imgHasLongDesc',
		'imgAltIsSameInText',
		'imgAltEmptyForDecorativeImages',
		'appletContainsTextEquivalentInAlt',
		'appletContainsTextEquivalent',
		'inputImageHasAlt',
		'inputImageAltIdentifiesPurpose',
		'inputImageAltIsShort',
		'inputImageAltIsNotPlaceholder',
		'areaHasAltValue',
		'areaAltIdentifiesDestination',
		'areaLinksToSoundFile',
		'objectMustContainText',
		'embedHasAssociatedNoEmbed',
		'inputImageNotDecorative',
		'areaAltRefersToText',
		'inputElementsDontHaveAlt',
		'aLinksToSoundFilesNeedTranscripts',
		'aLinksToMultiMediaRequireTranscript',
		'objectShouldHaveLongDescription',
		'inputTextHasLabel',
		'pNotUsedAsHeader',
		'selectHasAssociatedLabel',
		'textareaHasAssociatedLabel',
		'textareaLabelPositionedClose',
		'tableComplexHasSummary',
		'tableSummaryIsEmpty',
		'tableLayoutHasNoSummary',
		'tableLayoutHasNoCaption',
		'passwordHasLabel',
		'checkboxHasLabel',
		'fileHasLabel',
		'radioHasLabel',
		'passwordLabelIsNearby',
		'checkboxLabelIsNearby',
		'fileLabelIsNearby',
		'radioLabelIsNearby',
		'tableLayoutMakesSenseLinearized',
		'tableLayoutDataShouldNotHaveTh',
		'tableUsesCaption',
		'preShouldNotBeUsedForTabularLayout',
		'radioMarkedWithFieldgroupAndLegend',
		'tableSummaryDescribesTable',
		'tableIsGrouped',
		'tableUseColGroup',
		'tabularDataIsInTable',
		'tableCaptionIdentifiesTable',
		'tableSummaryDoesNotDuplicateCaption',
		'tableWithBothHeadersUseScope',
		'tableWithMoreHeadersUseID',
		'inputCheckboxRequiresFieldset',
		'documentVisualListsAreMarkedUp',
		'documentReadingDirection',
		'tableLayoutMakesSenseLinearized',
		'imgNotReferredToByColorAlone',
		'appletsDoneUseColorAlone',
		'inputDoesNotUseColorAlone',
		'objectDoesNotUseColorAlone',
		'scriptsDoNotUseColorAlone',
		'bodyColorContrast',
		'bodyLinkColorContrast',
		'bodyActiveLinkColorContrast',
		'bodyVisitedLinkColorContrast',
		'documentAllColorsAreSet',
		'appletUIMustBeAccessible',
		'objectInterfaceIsAccessible',
		'scriptUIMustBeAccessible',
		'scriptOndblclickRequiresOnKeypress',
		'scriptOnmousedownRequiresOnKeypress',
		'scriptOnmousemove',
		'scriptOnmouseoutHasOnmouseblur',
		'scriptOnmouseoverHasOnfocus',
		'scriptOnmouseupHasOnkeyup',
		'appletProvidesMechanismToReturnToParent',
		'objectProvidesMechanismToReturnToParent',
		'embedProvidesMechanismToReturnToParent',
		'documentMetaNotUsedWithTimeout',
		'blinkIsNotUsed',
		'marqueeIsNotUsed',
		'documentAutoRedirectNotUsed',
		'imgGifNoFlicker',
		'appletsDoNotFlicker',
		'objectDoesNotFlicker',
		'scriptsDoNotFlicker',
		'skipToContentLinkProvided',
		'framesHaveATitle',
		'frameTitlesDescribeFunction',
		'documentHasTitleElement',
		'documentTitleNotEmpty',
		'documentTitleIsShort',
		'documentTitleIsNotPlaceholder',
		'documentTitleDescribesDocument',
		'aLinksMakeSenseOutOfContext',
		'aSuspiciousLinkText',
		'aMustContainText',
		'documentLangNotIdentified',
		'documentLangIsISO639Standard',
		'documentWordsNotInLanguageAreMarked',
		'areaDontOpenNewWindow',
		'selectDoesNotChangeContext',
		'labelMustBeUnique',
		'labelMustNotBeEmpty',
		'formWithRequiredLabel',
		'documentIDsMustBeUnique',
		'svgContainsTitle',
		'headersHaveText',
	);
}
/*@}*/