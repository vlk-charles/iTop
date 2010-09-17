<?php
// Copyright (C) 2010 Combodo SARL
//
//   This program is free software; you can redistribute it and/or modify
//   it under the terms of the GNU General Public License as published by
//   the Free Software Foundation; version 3 of the License.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of the GNU General Public License
//   along with this program; if not, write to the Free Software
//   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

/**
 * Localized data
 *
 * @author      Erwan Taloc <erwan.taloc@combodo.com>
 * @author      Romain Quetiez <romain.quetiez@combodo.com>
 * @author      Denis Flaven <denis.flaven@combodo.com>
 * @license     http://www.opensource.org/licenses/gpl-3.0.html LGPL
 */

// Dictionnay conventions
// Class:<class_name>
// Class:<class_name>+
// Class:<class_name>/Attribute:<attribute_code>
// Class:<class_name>/Attribute:<attribute_code>+
// Class:<class_name>/Attribute:<attribute_code>/Value:<value>
// Class:<class_name>/Attribute:<attribute_code>/Value:<value>+
// Class:<class_name>/Stimulus:<stimulus_code>
// Class:<class_name>/Stimulus:<stimulus_code>+

//////////////////////////////////////////////////////////////////////
// Classes in 'bizmodel'
//////////////////////////////////////////////////////////////////////
//

// Dictionnay conventions
// Class:<class_name>
// Class:<class_name>+
// Class:<class_name>/Attribute:<attribute_code>
// Class:<class_name>/Attribute:<attribute_code>+
// Class:<class_name>/Attribute:<attribute_code>/Value:<value>
// Class:<class_name>/Attribute:<attribute_code>/Value:<value>+
// Class:<class_name>/Stimulus:<stimulus_code>
// Class:<class_name>/Stimulus:<stimulus_code>+




Dict::Add('DE DE', 'German', 'Deutsch', array(
        'Menu:ProblemManagement' => 'Problem Management',
        'Menu:ProblemManagement+' => 'Problem Management',
    	'Menu:Problem:Overview' => 'Übersicht',
    	'Menu:Problem:Overview+' => 'Übersicht',
    	'Menu:NewProblem' => 'Neues Problem',
    	'Menu:NewProblem+' => 'Neues Problem',
    	'Menu:SearchProblems' => 'Nach Problemen suchen',
    	'Menu:SearchProblems+' => 'Nach Problemen suchen',
    	'Menu:Problem:Shortcuts' => 'Shortcuts',
        'Menu:Problem:MyProblems' => 'Meine Probleme',
        'Menu:Problem:MyProblems+' => 'Meine Probleme',
        'Menu:Problem:OpenProblems' => 'Alle ungelösten Probleme',
        'Menu:Problem:OpenProblems+' => 'Alle ungelösten Probleme',
	'UI-ProblemManagementOverview-ProblemByService' => 'Probleme nach Service',
	'UI-ProblemManagementOverview-ProblemByService+' => 'Probleme nach Service',
	'UI-ProblemManagementOverview-ProblemByPriority' => 'Probleme nach Priorität',
	'UI-ProblemManagementOverview-ProblemByPriority+' => 'Probleme nach Priorität',
	'UI-ProblemManagementOverview-ProblemUnassigned' => 'Nicht zugewiesene Probleme',
	'UI-ProblemManagementOverview-ProblemUnassigned+' => 'Nicht zugewiesene Probleme',
	'UI:ProblemMgmtMenuOverview:Title' => 'Dashboard für das Problem Management',
	'UI:ProblemMgmtMenuOverview:Title+' => 'Dashboard für das Problem Management',

));
//
// Class: Problem
//

Dict::Add('DE DE', 'German', 'Deutsch', array(
	'Class:Problem' => 'Problem',
	'Class:Problem+' => '',
	'Class:Problem/Attribute:status' => 'Status',
	'Class:Problem/Attribute:status+' => '',
	'Class:Problem/Attribute:status/Value:new' => 'Neu',
	'Class:Problem/Attribute:status/Value:new+' => '',
	'Class:Problem/Attribute:status/Value:assigned' => 'Zugewiesen',
	'Class:Problem/Attribute:status/Value:assigned+' => '',
	'Class:Problem/Attribute:status/Value:resolved' => 'Gelöst',
	'Class:Problem/Attribute:status/Value:resolved+' => '',
	'Class:Problem/Attribute:status/Value:closed' => 'Geschlossen',
	'Class:Problem/Attribute:status/Value:closed+' => '',
	'Class:Problem/Attribute:org_id' => 'Kunde',
	'Class:Problem/Attribute:org_id+' => '',
	'Class:Problem/Attribute:org_name' => 'Name',
	'Class:Problem/Attribute:org_name+' => 'Gemeinsamer Name',
	'Class:Problem/Attribute:service_id' => 'Service',
	'Class:Problem/Attribute:service_id+' => '',
	'Class:Problem/Attribute:service_name' => 'Name',
	'Class:Problem/Attribute:service_name+' => '',
	'Class:Problem/Attribute:servicesubcategory_id' => 'Service-Kategorie',
	'Class:Problem/Attribute:servicesubcategory_id+' => '',
	'Class:Problem/Attribute:servicesubcategory_name' => 'Name',
	'Class:Problem/Attribute:servicesubcategory_name+' => '',
	'Class:Problem/Attribute:product' => 'Produkt',
	'Class:Problem/Attribute:product+' => '',
	'Class:Problem/Attribute:impact' => 'Auswirkung',
	'Class:Problem/Attribute:impact+' => '',
	'Class:Problem/Attribute:impact/Value:1' => 'Eine Person',
	'Class:Problem/Attribute:impact/Value:1+' => '',
	'Class:Problem/Attribute:impact/Value:2' => 'Einen Service',
	'Class:Problem/Attribute:impact/Value:2+' => '',
	'Class:Problem/Attribute:impact/Value:3' => 'Eine Abteilung',
	'Class:Problem/Attribute:impact/Value:3+' => '',
	'Class:Problem/Attribute:urgency' => 'Dringlichkeit',
	'Class:Problem/Attribute:urgency+' => '',
	'Class:Problem/Attribute:urgency/Value:1' => 'Niedrig',
	'Class:Problem/Attribute:urgency/Value:1+' => 'Niedrig',
	'Class:Problem/Attribute:urgency/Value:2' => 'Medium',
	'Class:Problem/Attribute:urgency/Value:2+' => 'Medium',
	'Class:Problem/Attribute:urgency/Value:3' => 'High',
	'Class:Problem/Attribute:urgency/Value:3+' => 'High',
	'Class:Problem/Attribute:priority' => 'Priorität',
	'Class:Problem/Attribute:priority+' => '',
	'Class:Problem/Attribute:priority/Value:1' => 'Niedrig',
	'Class:Problem/Attribute:priority/Value:1+' => '',
	'Class:Problem/Attribute:priority/Value:2' => 'Medium',
	'Class:Problem/Attribute:priority/Value:2+' => '',
	'Class:Problem/Attribute:priority/Value:3' => 'Hoch',
	'Class:Problem/Attribute:priority/Value:3+' => '',
	'Class:Problem/Attribute:workgroup_id' => 'Arbeitsgruppe',
	'Class:Problem/Attribute:workgroup_id+' => '',
	'Class:Problem/Attribute:workgroup_name' => 'Name',
	'Class:Problem/Attribute:workgroup_name+' => '',
	'Class:Problem/Attribute:agent_id' => 'Bearbeiter',
	'Class:Problem/Attribute:agent_id+' => '',
	'Class:Problem/Attribute:agent_name' => 'Name des Bearbeiter',
	'Class:Problem/Attribute:agent_name+' => '',
	'Class:Problem/Attribute:agent_email' => 'Email-Adresse des Bearbeiter',
	'Class:Problem/Attribute:agent_email+' => '',
	'Class:Problem/Attribute:related_change_id' => 'Zusammenhängender Change',
	'Class:Problem/Attribute:related_change_id+' => '',
	'Class:Problem/Attribute:related_change_ref' => 'Ref',
	'Class:Problem/Attribute:related_change_ref+' => '',
	'Class:Problem/Attribute:close_date' => 'Datum des Schließens',
	'Class:Problem/Attribute:close_date+' => '',
	'Class:Problem/Attribute:last_update' => 'Letzte Aktualisierung',
	'Class:Problem/Attribute:last_update+' => '',
	'Class:Problem/Attribute:assignment_date' => 'Datum der Zuordnung',
	'Class:Problem/Attribute:assignment_date+' => '',
	'Class:Problem/Attribute:resolution_date' => 'Datum der Lösung',
	'Class:Problem/Attribute:resolution_date+' => '',
	'Class:Problem/Attribute:knownerrors_list' => 'Bekannte Fehler',
	'Class:Problem/Attribute:knownerrors_list+' => '',
	'Class:Problem/Stimulus:ev_assign' => 'Zuweisen',
	'Class:Problem/Stimulus:ev_assign+' => '',
	'Class:Problem/Stimulus:ev_reassign' => 'Neu zuweisen',
	'Class:Problem/Stimulus:ev_reassign+' => '',
	'Class:Problem/Stimulus:ev_resolve' => 'Resolve',
	'Class:Problem/Stimulus:ev_resolve+' => '',
	'Class:Problem/Stimulus:ev_close' => 'Schließen',
	'Class:Problem/Stimulus:ev_close+' => '',
));

?>
