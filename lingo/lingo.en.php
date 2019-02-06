<?php
####################################################################
# Synch Lingo File
# Saloob, Inc. All rights reserved 2008+
# Author: Matthew Edmond
# Date: 2008-12-04
# URL: http://www.saloob.jp
# Email: sales@saloob.jp
####################################################################

$locale = "english";

$portal_title = $portal_config['portalconfig']['portal_title'];
$glb_domain = $portal_config['portalconfig']['glb_domain'];
$location = "/var/www/vhosts/".$glb_domain."/httpdocs/";
//$location = "/var/www/vhosts/default/httpdocs/";

#########################
# Menu Items
#########################

$strings["About"] = "About";
$strings["Login"] = "Login";
$strings["QuickLinks"] = "Quick Links";
$strings["Rules"] = "Rules";
$strings["Structure"] = "Structure";
$strings["Settings"] = "Settings";
$strings["PrivacyPolicy"] = "Privacy Policy";
$strings["TermsOfUse"] = "Terms Of Use";
$strings["BestViewedBrowsers"] = "<center>This site is best viewed using <a href=http://www.mozilla.org/en-US/firefox/‎target=Firefox>Firefox</a>, <a href=http://www.apple.com/safari/‎target=Safari>Safari</a> and <a href=http://www.google.com/chrome target=Chrome>Chrome</a><BR><img src=images/BrowserTrio.png width=190></center>";

#########################
# General Lingo
#########################

$strings["phone_office"] = "Office Phone";
$strings["phone_fax"] = "Office Fax";
$strings["website"] = "Website URL";
$strings["billing_address_street"] = "Billing Address Street";
$strings["billing_address_city"] = "Billing Address City";
$strings["billing_address_state"] = "Billing Address State";
$strings["billing_address_postalcode"] = "Billing Address Postalcode";

$strings["home"] = "Home";
$strings["Account"] = "Account";

$strings["AccessLevel"] = "Access Level";

$strings["Administration"] = "Administration";

$strings["ads"] = "Advertising";

$strings["affiliate_id"] = "Affiliate ID";

$strings["AffectedGroupType"] = "Affected Group Type";

$strings["Agreement"] = "By selecting this checkbox and submitting this form, you are acknowledging you have read the <a href=\"#\" onClick=\"loader('light');document.getElementById('light').style.display='block';doBPOSTRequest('light','Body.php', 'pc=".$portalcode."&do=Content&action=view&value=9d35be2b-7c56-9a39-b7af-540bc4ce781b&valuetype=Content&div=light');document.getElementById('fade').style.display='block';return false\"><B>Terms of Use</B></a> and <a href=\"#\" onClick=\"loader('light');document.getElementById('light').style.display='block';doBPOSTRequest('light','Body.php', 'pc=".$portalcode."&do=Content&action=view&value=c3593693-a0a4-c389-7d05-541ed5abdfbf&valuetype=Content&div=light');document.getElementById('fade').style.display='block';return false\"><B>Master Subscription Agreement</B></a> for using this service.";

$strings["Average"] = "Average";

$strings["Build"] = "Build";

$strings["Cancel"] = "Cancel";

$strings["Calendar"] = "Calendar";

$strings["Category"] = "Category";
$strings["Categories"] = "Categories";

$strings["Close"] = "Close";

$strings["date"] = "Date";
$strings["Date"] = "Date";
$strings["date_custom"] = "Custom Date";
$strings["DateEnd"] = "End Date";
$strings["DateStart"] = "Start Date";
$strings["DateCurrent"] = "Current Date";

$strings["Facebook_MessagePost"] = "A message will be posted to your Facebook wall with the link..";
$strings["Facebook_MessagePostPrivate"] = "A private message will be posted to your Facebook friends - select on the next screen..";

$strings["Friend"] = "Friend";
$strings["Friends"] = "Friends";

$strings["ID"] = "ID#";
$strings["Importance"] = "Importance";

$strings["Industry"] = "Industry";
$strings["Industries"] = "Industries";

$strings["Multiple"] = "Multiple";

$strings["Summary"] = "Summary";

$strings["Time"] = "Time";
$strings["TimeDimension"] = "Time Dimension";
$strings["TimeDimensions"] = "Time Dimensions";

$strings["TimeEnd"] = "End Time";
$strings["TimeStart"] = "Start Time";

$strings["Currency"] = "Currency";
$strings["Currencies"] = "Currencies";

$strings["Description"] = "Description";

$strings["GoldBlocks"] = "(Gold Blocks)";

$strings["Latitude"] = "Latitude";
$strings["Longitude"] = "Longitude";

$strings["City"] = "City";
$strings["Street"] = "Street";
$strings["State"] = "State";
$strings["Zip"] = "Zip";

$strings["Language"] = "Language";
$strings["List"] = "List";

$strings["Year"] = "Year";
$strings["Years"] = "Years";
$strings["Month"] = "Month";
$strings["Months"] = "Months";
$strings["Day"] = "Day";
$strings["Days"] = "Days";
$strings["Hour"] = "Hour";
$strings["Hours"] = "Hours";
$strings["Minute"] = "Minute";
$strings["Minutes"] = "Minutes";
$strings["Second"] = "Second";
$strings["Seconds"] = "Seconds";

$strings["Monetary"] = "Monetary";

$strings["My"] = "My";
$strings["Me"] = "Me";

$strings["NA"] = "N/A";

$strings["Name"] = "Name";

$strings["or"] = " or ";

$strings["OtherItems"] = "Other Items";

$strings["Origin"] = "Origin";
$strings["Origination"] = "Origination";

$strings["Parent"] = "Parent";

$strings["Population"] = "Population";
$strings["Probability"] = "Probability/Surety";

$strings["PercentageWarning"] = "% (Format: 1, 0.98 or 0.01, etc.,)";
$strings["DecimalWarning"] = "(Format: 12.01, 0.0001, -18.11, 10000.63454, etc.,)";
$strings["IntegerWarning"] = "(Format: 12, 0, -18, 10000, etc.,)";
$strings["DateTimeWarning"] = "(Format: 2011-12-28 21:56)";

$strings["Positivity"] = "Positivity";
$strings["Purpose"] = "Purpose/Motivation";
$strings["Purposes"] = "Purposes/Motivations";

$strings["Quantity"] = "Quantity";
$strings["QuickStats"] = "Quick Stats";

$strings["Recipients"] = "Recipients";

$strings["Related"] = "Related";
$strings["RelatedContent"] = "Related Content";
$strings["RelatedTypes"] = "Related Types";

$strings["RelatedAccount"] = "Related Account";
$strings["RelatedAccountSharing"] = "Related Account Sharing";

$strings["Return"] = "Return";

$strings["Register"] = "Register";
$strings["Register_Info"] = "<B>Making an account is easy - we just need 4 bits of information to get started.</B><P>
All fields with an asterix (*) are required. We look forward to you joining us!<P>";

$strings["Required"] = "Required";
$strings["RequiredMessage"] = "The fields marked with an asterix (*) must be completed.";

$strings["Score"] = "Score";
$strings["Scores"] = "Scores";
$strings["Score(s)"] = "Score(s)";
$strings["PublicStatus"] = "Public Status";
$strings["Status"] = "Status";
$strings["Subject"] = "Subject";
$strings["Title"] = "Title";
$strings["Total"] = "Total";

$strings["Update"] = "Update";
$strings["Updates"] = "Updates";

$strings["Urgency"] = "Urgency";
$strings["Urgent"] = "Urgent";

$strings["You"] = "You";
$strings["Your"] = "Your";

$strings["Value"] = "Value";
$strings["Venue"] = "Venue";

$strings["CompletionRate"] = "Completion Rate";
$strings["Completed"] = "Completed";
$strings["Link"] = "Link";
$strings["LinkExternal"] = "External Link";

#########################
# Shared Effects
#########################

$strings["Action"] = "Action";
$strings["Actions"] = "Actions";
$strings["ActionsPublic"] = "Public Actions";

$strings["ParentEffect"] = "Parent Effect";

$strings["Effect"] = "Effect";
$strings["Effects"] = "Effects";
$strings["Effect_add"] = "Add Effect";

$strings["Emotion"] = "Emotion";
$strings["Emotions"] = "Emotions";

$strings["FinalReport_PositiveValueOf"] = "Positive value of ";
$strings["FinalReport_NegativeValueOf"] = "Negative value of ";
$strings["FinalReport_AccordingToThe"] = "According to the ";
$strings["FinalReport_EffectsSubmitted"] = " shared side-effect(s) submitted, having ";
$strings["FinalReport_GroupTypes"] = " unique Group Type(s) potentially affected, ";
$strings["FinalReport_PeopleBelieve"] = " people believe there is a ";
$strings["FinalReport_PersonBelieves"] = " person believes there is a ";
$strings["FinalReport_Probability"] = "% probability/surety that ";
$strings["FinalReport_WillHaveAnAverage"] = " will have an average ";
$strings["FinalReport_SeeBelow"] = "See below for the full report breakdown. The average level of POSITIVITY of each item will determine the scale colour and the (+/-) number. The positivity is a subjective, yet valuable number, as it shows the overal positive vibes that the group is feeling about this.";

$strings["VoteReport_AccordingToThe"] = "According to the ";
$strings["VoteReport_VotesSubmitted"] = " vote(s) submitted, ";
$strings["VoteReport_PeopleBelieve"] = " people believe the average positivity is ";
$strings["VoteReport_PersonBelieves"] = " person believes the average positivity is ";
$strings["VoteReport_ForThis"] = " for this item.";
$strings["VoteReport_SeeBelow"] = "See below for the full report breakdown.";

#########################

$strings["Accounts"] = "Accounts";
$strings["ParentAccount"] = "Parent Account";
$strings["PersonalAccount"] = "Personal Account";
$strings["PersonalDetails"] = "Personal Details";
$strings["PersonalDetailsUpdate"] = "To update your personal details, please do so ";
$strings["Account"] = "Account";
$strings["AccountDetails"] = "Account Details";
$strings["AccountName"] = "Account Name";
$strings["AccountRelationship"] = "Account Relationship";
$strings["AccountRelationships"] = "Account Relationships";
$strings["AccountRelationshipDetails"] = "Account Relationships allow for businesses to share information, services and perform various activities together, such as Manage Projects, Tasks, Account Administration, complete Tickets and Activities.";

#########################

$strings["Administrators"] = "Administrators";

#########################

$strings["Advisory"] = "Advisory";
$strings["AdvisorySettings"] = "Advisory Settings";
$strings["AdvisoryCharacter"] = "Advisory Character";
$strings["AdvisoryIntro"] = "<B>Welcome to our Advisory section.</B><BR>Here, we aim to offer tips and related information to support your work.";
$strings["AdvisoryWelcomeBack"] = "Welcome back, XXXXXX. How can I help you today?";
$strings["AdvisoryWelcomeFriend"] = "Welcome friend. I am here to help you with whatever you need..";
$strings["AdvisoryMemberClickToViewAdvisory"] = "XXXXXX, click me to view our Advisory section..";
$strings["AdvisoryFriendClickToViewAdvisory"] = "Click me to view our Advisory section..";

#########################

$strings["Agencies"] = "Agencies";
$strings["Agent"] = "Agent";
$strings["AgencyTenders"] = "Agency Tenders";

#########################

$strings["Anonymous"] = "Anonymous";
$strings["AnonymousUser"] = "Anonymous User";

#########################

$strings["Article"] = "Article";
$strings["Articles"] = "Articles";

#########################

$strings["Billing"] = "Billing";

#########################

$strings["BusinessAccount"] = "Business Account";
$strings["BusinessAccounts"] = "Business Accounts";

#########################

$strings["Call"] = "Call";
$strings["CallTree"] = "Call Tree";
$strings["CallTrees"] = "Call Trees";
$strings["Calls"] = "Calls";
$strings["CallLogs"] = "Call Logs";

#########################

$strings["Cause"] = "Cause";
$strings["Causes"] = "Causes";
$strings["Causes_Content_Short"] = "Causes are an important rallying point for interested citizens (you!) to keep in-step with an issue that means a lot to you. Causes can have multiple events. ";
$strings["Causes_Content_Long"] = "Causes can be created from Governments and Political Parties - the usual source of citizen protest - or support. Simply add your cause and share it with your friends and start getting some activity going. We have also added Side Effects so you can collaborate with your fellow citizens to try and predict or record the positive and negative side effects of the causes.";

#########################

$strings["ChildSystem"] = "Child System";

#########################

$strings["Comments"] = "Comments";
$strings["Comment"] = "Comment";
$strings["MyComments"] = "My Comments";
$strings["CommentAnonymous"] = "Anonymous Comment";

#########################
# Configuration Items

$strings["ConfigurationItemParent"] = "Configuration Item Parent";
$strings["ConfigurationItem"] = "Configuration Item";
$strings["ConfigurationItems"] = "Configuration Items";
$strings["ConfigurationItemsMessage"] = "CIs (Configuration Items) are important items of data that help shape our data sets and manage our services. CIs can be attached to Services, Service SLA Requests, Projects and Tickets to provide necessary related information, such as call trees, inventory, service assets and more. As an example, providing a call tree for escalations are necessary when taking Customer calls and creating or updating tickets related to a particular incident or request. This call tree CI set should be related to one or more Service SLA Requests for easy reference when managing tickets.";
$strings["RelatedConfigurationItems"] = "Related Configuration Items";
$strings["ConfigurationItemType"] = "Configuration Item Type";
$strings["ConfigurationItemTypes"] = "Configuration Item Types";
$strings["RelatedConfigurationItemTypes"] = "Related Configuration Item Types";
$strings["ConfigurationItemSets"] = "Configuration Item Sets";
$strings["ExternalSystemsConfiguration"] = "External Systems";
$strings["InfraConfiguration"] = "Infrastructure";
$strings["SystemConfiguration"] = "System Configuration";
$strings["PortalConfiguration"] = "Portal Configuration";
$strings["DataCenter"] = "Data Center (DC)";
$strings["DataCenters"] = "Data Centers (DCs)";
$strings["DCFloor"] = "DC Floor (F)";
$strings["DCFloors"] = "DC Floors (Fs)";
$strings["CI_Rack"] = "Rack";
$strings["CI_Racks"] = "Racks";
$strings["CI_System"] = "System";
$strings["CI_RackUnitSpace"] = "Rack Unit Space";
$strings["CI_RackServerUnit"] = "Rack Server Unit";
$strings["CI_Blade"] = "Blade";
$strings["CI_Blades"] = "Blades";
$strings["CI_BladeChasis"] = "Blade Chasis";
$strings["CI_Server"] = "Server";
$strings["CI_ServerStatus"] = "Server Status";
$strings["CI_ServerStatusOnline"] = "Online";
$strings["CI_ServerStatusOffline"] = "Offline";
$strings["CI_ServerStatusMaintenance"] = "Maintenance";
$strings["CI_ServerStatusBackup"] = "Back-up";
$strings["CI_Servers"] = "Servers";
$strings["CI_Host"] = "Host";
$strings["CI_Hosts"] = "Hosts";

#########################

$strings["Contact"] = "Contact";
$strings["Contacts"] = "Contacts";

#########################

$strings["Countries"] = "Countries";
$strings["Country"] = "Country";
$strings["CountryCapital"] = "Capital";
$strings["CountryPopulation"] = "Country Population";

#########################

$strings["Content"] = "Content";
$strings["ContentType"] = "Content Type";
$strings["PortalContentType"] = "Portal Content Type";
$strings["Image"] = "Image";
$strings["Images"] = "Images";
$strings["ImageUploadCompleteRefresh"] = "Upload complete - click the above XXXX link to reload page...";
$strings["ImageThumbnail"] = "Image Thumbnail";
$strings["ImageThumbnailURL"] = "Thumbnail URL";
$strings["Thumbnail"] = "Thumbnail";
$strings["GalleryImage"] = "Gallery Image";
$strings["MediaType"] = "Media Type";
$strings["MediaTypes"] = "Media Types";
$strings["MediaSource"] = "Media Source";
$strings["HTMLEditorShow"] = "Show HTML Editor";
$strings["HTMLEditorHide"] = "Hide HTML Editor";
$strings["HTMLEditorCopyMessage"] = "Select source in the HTML Editor and copy into the text box below";

#########################

$strings["Credits"] = "Credits";

#########################

$strings["Dashboard"] = "Dashboard";
$strings["DashboardReturn"] = "Return to my Dashboard";

#########################

$strings["Departments"] = "Departments";
$strings["Department"] = "Department";
$strings["DepartmentRoles"] = "Department Role(s)";
$strings["DepartmentAgencies"] = "Department Agencies";

#########################

$strings["Developers"] = "Developers";
$strings["DevelopersIntroShort"] = "Developers - we need your help to take Realpolitika to greater levels - put Government where it belongs - in the hands of the citizens!";

#########################

$strings["Ethics"] = "Ethics";

#########################

$strings["FeeType"] = "Fee Type";
$strings["FeeTypes"] = "Fee Types";

#########################

$strings["Email"] = "Email";
$strings["Emails"] = "Emails";
$strings["EmailExtraAddressees"] = "Extra Addressees (Sep by comma,)";
$strings["EmailLogs"] = "Email Logs";
$strings["EmailConvertToTicket"] = "Create Ticket";
$strings["EmailFiltering"] = "Email Filtering";
$strings["EmailFilterRecipient"] = "Email Filter Recipient";
$strings["EmailFilterRecipients"] = "Email Filter Recipients";
$strings["EmailFilterSet"] = "Email Filter Set";
$strings["EmailFilterSets"] = "Email Filter Sets";
$strings["EmailFilterSender"] = "Email Filter Sender";
$strings["EmailFilterString"] = "Email Filter String";
$strings["EmailFilterTemplate"] = "Email Filter Template";
$strings["EmailFilterTemplates"] = "Email Filter Templates";
$strings["EmailFilterTrigger"] = "Email Filter Trigger";
$strings["EmailFilterTriggers"] = "Email Filter Triggers";

$strings["EmailRecipient"] = "Email Recipient";
$strings["EmailRecipients"] = "Email Recipients";
$strings["EmailTemplate"] = "Email Template";
$strings["EmailTemplates"] = "Email Templates";

$strings["SendEmail"] = "Send Email";

#########################

$strings["Event"] = "Event";
$strings["Events"] = "Events";
$strings["Events_Usage"] = "Events can be any action at all - present or past - that relates to some area you are interested in. The event could be a birth, death, arrest, invasion, protest, release - any event in history. Events are different from Causes - in that a Cause can have many events - such as multiple protests for a Cause to overthrow a Dictator.";
$strings["MyEvents"] = "My Events";
$strings["EventsCreate"] = "Create an Event and post it on Facebook, invite connections...";
$strings["Event_add"] = "Add Event";
$strings["EventURL"] = "Event URL";

#########################

$strings["FAQ"] = "FAQ";
$strings["FrequentlyAskedQuestions"] = "";

#########################

$strings["File"] = "File";
$strings["Files"] = "Files";
$strings["UploadFile"] = "Upload File";

#########################

$strings["Filter"] = "Filter";
$strings["Filters"] = "Filters";
$strings["FilterDayRange"] = " Day Range Filter";
$strings["FilterDateRange"] = "Date Range Filter";
$strings["FilterTimeRange"] = "Time Range Filter";
$strings["FilterDateTimeConcat"] = "Date+Time Concat Filter";
$strings["FilterSet"] = "Filter Set";
$strings["FilterSets"] = "Filter Sets";
$strings["FilterString"] = "Filter String";
$strings["FilterStrings"] = "Filter Strings";
$strings["FilterCreateTicket"] = "Create Ticket";
$strings["FilterCreateActivity"] = "Create Activity";
$strings["FilterSendEmail"] = $strings["SendEmail"];
$strings["FilterAutoReplyToSender"] = "Auto-reply to Sender";
$strings["FilterTriggerStringSubjectOnly"] = "Filter by String in Subject only";
$strings["FilterTriggerStringBody"] = "Filter by String in Body";
$strings["FilterTriggerStringBodyMultipleAnyOK"] = "Filter by multiple Strings in Body (any OK)";
$strings["FilterTriggerStringSubjectExactMatchOnly"] = "Filter by String Exactly Matches Subject only";
$strings["FilterTriggerSenderStringSubjectExactMatch"] = "Filter by Sender and Subject Exact String match";
$strings["FilterTriggerSenderStringBodyMatch"] = "Filter by Sender and Body String match";
$strings["FilterTriggerSenderEmailOnly"] = "Filter by Sender Email only";
$strings["FilterTriggerNoMatchCatchAll"] = "No Match Catch All";
$strings["FilterExplanation"] = "<font size=4><B>How to use Filters</B></font>
<P>
1) <B>Create a Filter Set</B> - Can hold multiple filters
<P>
2) <B>Create Filters</B> - can hold multiple components
<P>
3) <B>Add Components to Filters</B>, such as;
<P>
* <B>".$strings["CI_Servers"]."</B> - will be used for placeholders and searching text - and relating tickets to Infrastructure<BR>
* <B>".$strings["ServiceSLARequests"]."</B> - necessary to be able to create tickets for action<BR>
* <B>".$strings["FilterDayRange"]."</B> - email arrival between two days or on a particular day<BR>
* <B>".$strings["FilterDateRange"]."</B> - email arrival between two dates or on a particular date<BR>
* <B>".$strings["FilterTimeRange"]."</B> - email arrival between two times or at a particular time<BR>
* <B>".$strings["FilterString"]."</B> - search in subject and/or body - decide by triggers
<P>
4) <B>Setting Triggers</B>, such as;
<P>
* <B>".$strings["FilterTriggerStringSubjectOnly"]."</B><BR>
* <B>".$strings["FilterTriggerStringBody"]."</B><BR>
* <B>".$strings["FilterTriggerStringSubjectExactMatchOnly"]."</B><BR>
* <B>".$strings["FilterTriggerSenderStringSubjectExactMatch"]."</B><BR>
* <B>".$strings["FilterTriggerSenderStringBodyMatch"]."</B><BR>
* <B>".$strings["FilterTriggerSenderEmailOnly"]."</B>
<P>
5) <B>".$strings["FilterCreateTicket"]." [Yes/No]</B> - if all the triggers match to true
<P>
6) <B>".$strings["EmailTemplate"]."</B> - that will include the email delievered content within a placeholder.
<P>
7) <B>[Placeholders]</B></B> - will replace certain pre-set text in emails and tickets held within square brackets;
<P>
<B>[TITLE_START]</B> Email Title <B>[TITLE_END]</B><BR>
<B>[DATEFROM]</B> to <B>[DATETO]</B><BR>
<B>[VIRUS_COUNT]</B><BR>
<B>[COMPANY]</B> and <B>[CONTACT]</B><BR>
<B>[SERVER]</B> - Will add the servers and IPs found within the email or included during Filter build<BR>
<B>[DATE]</B> - Will add the date of the alert email coming in<BR>
<B>[ALERT_MESSAGE]</B> - Will add the body of an alert email here<BR>

";

#########################

$strings["GovernmentLevels"] = "Government Levels";
$strings["NoRecordedLevels"] = "No Recorded Levels";

#########################

$strings["Government"] = "Government";
$strings["Governments"] = "Governments";
$strings["VirtualGovernments"] = "Virtual Governments";
$strings["RecognisedGovernments"] = "Recognised Governments";
$strings["GovernmentCreate"] = "Create a Government";
$strings["GovernmentManage"] = "Manage this Government";

#########################

$strings["GovernmentTypes"] = "Government Types";
$strings["GovernmentType"] = "Government Type";

#########################

$strings["GovernmentStates"] = "Government State(s)";
$strings["StateGovernment"] = "State Government";
$strings["GovernmentState"] = "Government State";
$strings["States"] = "States";
$strings["State"] = "State";

#########################

$strings["Roles"] = "Role(s)";
$strings["RolesNumber"] = "Number of Roles";

#########################

$strings["GroupType"] = "Group Type";
$strings["GroupTypes"] = "Group Types";

#########################

$strings["Integrations"] = "Integrations";
$strings["Integrations_Right"] = "<font size=2>We are currently integrated with the following services;</font><P>
<font size=2><B>Facebook</B> - for enhanced personal social collaboration</font><BR>
<font size=2><B>LinkedIn</B> - for enhanced professional social collaboration</font><BR>
<font size=2><B>SugarCRM</B> - for enhanced business activities collaboration</font><P>
<font size=2>We will continue to work on these and others to make our Service the most convenient and valuable social collaboration service for you, your friends, family and peers.";

#########################

$strings["TopSearchedKeywords"] = "Top Searched Keywords";

########################

$strings["Industry"] = "Industry";

#########################

$strings["Language"] = "Language";
$strings["Languages"] = "Languages";

#########################

$strings["TheLobby"] = "The Lobby";
$strings["Lobby"] = "Lobby";
$strings["Lobbyists"] = "Lobbyists";
$strings["LobbyistsIntroShort"] = "The Lobby is section dedicated to Lobbyists. ";

#########################

$strings["Location"] = "Location";
$strings["Locations"] = "Locations";

#########################

$strings["Meeting"] = "Meeting";
$strings["Meetings"] = "Meetings";
$strings["Meeting_start"] = "Start Date";
$strings["Meeting_end"] = "End Date";
$strings["Meeting_location"] = "Location";
$strings["Meeting_password"] = "Password";
$strings["Meeting_join_url"] = "Join URL";
$strings["Meeting_host_url"] = "Host URL";
$strings["Meeting_displayed_url"] = "Displayed URL";
$strings["Meeting_duration_hours"] = "Duration Hours";
$strings["Meeting_duration_minutes"] = "Duration Minutes";
$strings["Meeting_reminder_time"] = "Reminder Time";
$strings["Meeting_email_reminder_time"] = "Email Reminder Time";
$strings["Meeting_email_reminder_sent"] = "Email Reminder Sent";
$strings["Meeting_outlook_id"] = "Outlook ID";
$strings["Meeting_sequence"] = "Meeting Sequence";
$strings["Meeting_repeat_type"] = "Repeat Type";
$strings["Meeting_repeat_interval"] = "Repeat Interval";
$strings["Meeting_repeat_dow"] = "Repeat Dow";
$strings["Meeting_repeat_until"] = "Repeat Until";
$strings["Meeting_repeat_count"] = "Repeat Count";
$strings["Meeting_repeat_parent_id"] = "Repeat Parent";
$strings["Meeting_recurring_source"] = "Recurring Source";
$strings["Meeting_add"] = "Add New Meeting";

#########################

$strings["Message"] = "Message";
$strings["ParentMessage"] = "Parent Message";
$strings["Messages"] = "Messages";
$strings["MembersMessages"] = "Members Messages";
$strings["MessageReply"] = "Reply to message";
$strings["MessageRead"] = "Message Read";
$strings["MessageUnread"] = "Message Unread";
$strings["MessageReplied"] = "Message Replied";
$strings["MessageRecipient"] = "Recipient";
$strings["MessageRecipientAccount"] = "Recipient Account";
$strings["MessageSender"] = "Sender";
$strings["MessageSenderAccount"] = "Sender Account";

#########################

$strings["News"] = "News";
$strings["NewsType"] = "News Type";
$strings["NewsTypes"] = "News Types";
$strings["NewsCategory"] = "News Category";
$strings["NewsCategories"] = "News Categories";

#########################

$strings["Nominations"] = "Nominations";
$strings["Nominee"] = "Nominee";
$strings["Nominees"] = "Nominees";
$strings["NominationsForRole"] = "Nominations for this role";

#########################

$strings["SourceObjects"] = "Source Objects";
$strings["SourceObjects_Usage"] = "Source Objects are the names of items in your own application that you wish to use here.<BR>
As an example, if you wish to use SugarCRM and wish to have our service automatically extract Opportunities, then you should register the Object 'Opportunities' - and if your SugarCRM access info is correct, we can collect your Opportunities to use here for collaboration.";

$strings["ExternalSourceType"] = "External Source Type";

$strings["ExternalSources_Explanation"] = "<font size=2><B>Step 1: Register your External Source.</B> This is a remote system or service outside of Shared Effects that you can integrate here. For example, you can register your SugarCRM site with your access credentials, and Shared Effects will automatically reach out to your system and bring back the modules so you can register them here.</font><P>
<font size=2><B>Step 2: Register your Source Objects.</B> These are the modules from the various External Sources (SugarCRM). Once registered, you will be able to create Actions and Side Effects based on items registered within your external source under that module.</font><P>
<font size=2><B>Step 3: Select a Source Object Item record.</B> This will become a Shared Effects Action. An example is if you registered the Project module (Source Object) and one of the actual registered projects within your external source would be an item record of that object (Ex: Project: Build new company web-site). You can also register the Tasks of your Projects as Actions that could also have Side Effects.</font><P>
<font size=2>In SugarCRM, the Project, Opportunity and Task modules are the ones that provide the most chance for collaboration and opinion in most businesses - try it out!</font>";

$strings["ExternalSources_ProjectTasksExplanation"] = "<font size=2>We have determined that this Action is based on a SugarCRM Project and have checked for any related <B>Project Tasks</B> which could also be registered as completely new Actions or Side Effects. As you had previously done by registering your Project <B>object</B> from SugarCRM (before registering the actual Project <B>record</B> as an Action, you also need to register the Project Task <B>object</B> to be able to create Actions or Side Effects. We have provided a link below to show whether this has been done or not.";

$strings["ExternalSources_UserRegistration"] = "<font size=2>The following Users were found using your access credentials. Users with the green tick (<img src=images/icons/ok.gif width=16>) are already members of Shared Effects (same email address). Collaboration in Shared Effects can be done between Company Account members or people within your Social Network. To add the remaining users to Shared Effects so they can collaborate with you, select the respective checkbox and submit by ckicking 'Add'</font>";

#########################

$strings["Facebook"] = "Facebook";

$strings["Facebook_InviteFriends_Explanation"] = "<font size=2>To invite friends from Facebook, you first need to be logged into Facebook and have accepted to join this service. Then, simply click on the left menu link to open up the Facebook window and click the \"Invite Friends\" link. If your friends already exist here, they will show up below and you can connect with them easily by clicking the checkbox.</font>";

#########################

$strings["Opportunity"] = "Opportunity";
$strings["Opportunities"] = "Opportunities";

#########################

$strings["Organisations"] = "Organisations";
$strings["Organisation"] = "Organisation";
$strings["OrganisationRoles"] = "Organisation Roles";
$strings["OrganisationPolicies"] = "Organisation Policies";
$strings["OrganisationCreate"] = "Create an Organisation";
$strings["OrganisationManage"] = "Manage this Organisation";
$strings["OrganisationManageYouAreAdmin"] = "You are an Adminstrator of this Organisation";

#########################

$strings["Policy"] = "Policy";
$strings["Policies"] = "Policies";

#########################

$strings["AccountInformation"] = "Account Information";
$strings["AccountType"] = "Account Type";
$strings["AccountTypeProviderPartner"] = "Provider Partner";
$strings["AccountServiceProvider"] = "Service Provider";
$strings["AccountTypeResellerPartner"] = "Reseller Partner";
$strings["AccountTypeCustomer"] = "Customer";
$strings["MyAccount"] = "My Account";
$strings["WorkArea"] = "Work Area";
$strings["Donations"] = "Donations";
$strings["TopVotes"] = "Top Votes";
$strings["PopularPeopleRoles"] = "Popular People & Roles";  
$strings["MyVotes"] = "My Votes";
$strings["Vote"] = "Vote";
$strings["Votes"] = "Votes";
$strings["ViewFullVotes"] = "Full Vote Statistics for ";

#########################

$strings["Journalists"] = "Journalists";
$strings["Journalists_Info"] = "Journalists are a special category of Users we deemed to be absolutely vital for providing a respected coverage of the Governments, Departments, Agencies, people, actions and activities going on in the world. Joining as a Journalist is by invitation only - by existing journalists.";

#########################

$strings["RequestOwnershipTransfer"] = "Request Ownership Transfer";

$strings["Hierarchical_Map"] = "Hierarchical Map";
$strings["Hierarchical_Map_Info"] = "The Hierarchical Map below represents the various levels within this Government/Type all the way down to the roles. If you click on a Government Type, you can see similar maps but with just the structure provided for that government type. To be able to interact with the map, such as nominating yourself or others or applying for any particular roles - you need to be logged-in.";

#########################

$strings["Law"] = "Law";
$strings["LawCase"] = "Law Case";
$strings["LawCases"] = "Law Cases";
$strings["Laws"] = "Laws";
$strings["LawsCreate"] = "Create Law";

#########################

$strings["MTV"] = "Media TV";

#########################

$strings["Members"] = "Members";
$strings["Member"] = "Member";
$strings["MemberProfile_Note"] = "Notes about updating your profile. You can choose what name to show for comments you make and other submissions - as well as for Social Networks you join. If not set - it will show as Anonymous. You can use your real name, nickname or special cloakname.";

#########################

$strings["NotificationContacts"] = "Notification Contacts";
$strings["NotificationContactsSet"] = "Set Contacts";

#########################

$strings["Portal"] = "Portal";
$strings["PortalSignature"] = "Have a great day!";

#########################

$strings["ManageProject"] = "Manage Projects";
$strings["Project"] = "Project";
$strings["Projects"] = "Projects";
$strings["ProjectTask"] = "Project Task";
$strings["ProjectTaskSummary"] = "Project Task Summary";
$strings["TaskSummaryByDate"] = "Task Summary by Date";
$strings["TaskSummaryByStatus"] = "Task Summary by Status";
$strings["ProjectTasks"] = "Project Tasks";
$strings["ProjectProcess"] = "Project Process";
$strings["RelatedProject"] = "Related Project";
$strings["RelatedProjects"] = "Related Projects";
$strings["RelatedTasks"] = "Related Tasks";
$strings["ParentTask"] = "Parent Task";
$strings["TaskNumber"] = "Task Number";

$strings["predecessors"] = "Predecessors";
$strings["date_start"] = "Start Date";
$strings["date_finish"] = "Finish Date";
$strings["time_start"] = "Start Time";
$strings["time_finish"] = "Finish Time";
$strings["AccumulatedMinutes"] = "Accumulated Minutes";
$strings["duration"] = "Duration";
$strings["duration_unit"] = "Duration Unit";
$strings["percent_complete"] = "Percent Complete";
$strings["date_due"] = "Date Due";
$strings["time_due"] = "Time Due";
$strings["parent_task_id"] = "Parent Task";
$strings["assigned_user_id"] = "Assigned User";
$strings["modified_user_id"] = "Modified User";
$strings["priority"] = "Priority";
$strings["created_by"] = "Creator";
$strings["milestone_flag"] = "Milestone Flag";
$strings["order_number"] = "Order Number";

$strings["estimated_effort"] = "Estimated Effort";
$strings["actual_effort"] = "Actual Effort";
$strings["deleted"] = "Deleted";
$strings["utilization"] = "Utilization";

#########################

$strings["ITILStage"] = "ITIL Stage";
$strings["ITILStageProcess"] = "ITIL Process";
$strings["ServiceOperationProcess"] = "Service Operation Process";

#########################

$strings["Search"] = "Search";
$strings["SearchMessage"] = "The following are the results of a search using keyword: XXXXXX";

#########################

$strings["Security"] = "Security";
$strings["Access"] = "Access";
$strings["Role"] = "Role";
$strings["Roles"] = "Roles";
$strings["Module"] = "Module";
$strings["Modules"] = "Modules";
$strings["Import"] = "Import";
$strings["Export"] = "Export";
$strings["Edit"] = "Edit";
$strings["Delete"] = "Delete";
$strings["Create"] = "Create";
$strings["ViewDetails"] = "View Details";
$strings["ViewList"] = "View List";
$strings["SecurityLevel"] = "Security Level";
$strings["SecurityItemType"] = "Security Item Type";

#########################

$strings["SOW"] = "SOW (Statement Of Work)";
$strings["SOWItem"] = "SOW Item";
$strings["SOWItemParent"] = "Parent SOW Item";
$strings["SOWItems"] = "SOW Items";

#########################

$strings["Resource"] = "Resource";
$strings["Capacity"] = "Capacity";
$strings["ResourcesCapacity"] = "Resources Capacity";
$strings["Resources"] = "Resources";

#########################

$strings["Rules"] = "Rules";

#########################
# Services

$strings["AccountServices"] = "Account Services";
$strings["AccountsServices"] = $strings["AccountServices"];
$strings["AccountServicesSLA"] = "Account Service's SLA";
$strings["AccountsServicesSLA"] = $strings["AccountServicesSLA"]; 
$strings["AccountServicesSLAs"] = "Account Service's SLAs";
$strings["AccountsServicesSLAs"] = $strings["AccountServicesSLAs"];
$strings["CatalogService"] = "Catalog Service";
$strings["CatalogServices"] = "Catalog Services";
$strings["CatalogServicesSLA"] = "Catalog Service's SLA";
$strings["CatalogServicesSLAs"] = "Catalog Service's SLAs";
$strings["CatalogServicesAddTo"] = "Add to Service Catalog";
$strings["BaseService"] = "Base Service";
$strings["BaseServices"] = "Base Services";
$strings["Service"] = "Service";
$strings["ServicesProvider"] = "Service Provider";
$strings["Services"] = "Services";
$strings["ServicesManagement"] = "Services Management";
$strings["ServiceSLA"] = "Service SLA";
$strings["ServiceSLAs"] = "Service SLAs";
$strings["ServiceSLARequest"] = "Request Service & SLA";
$strings["ServiceSLARequestMessage"] = "Here, you can request a Service's available SLA(s). The request acts as a placeholder or wrapper within which tickets and activities will be created. Tickets represent actual chargable services that will be provided and SLA timing starts upon ticket creation.
<P>
Setting Projects, Tasks and SOW Items also allows for these items to be automatically set for tickets when created for better resource allocation and classification.";
$strings["ServiceSLARequests"] = "Service & SLA Requests";
$strings["SetServiceSLAPricing"] = "Set Service SLA Pricing";
$strings["SLAManagement"] = "SLA Management";
$strings["ServiceSLAManagement"] = "Service SLA Management";
$strings["ServiceSLAPrices"] = "Service SLA Prices";
$strings["ServiceSLAPrice"] = "Service SLA Price";
$strings["ServicesPricing"] = "Services Pricing";
$strings["ServicesPrices"] = "Services Prices";
$strings["ServicesPrices_RequireLogin"] = "Requests for services are based on prices, but requires you to be logged-in first.";
$strings["SetNewServiceSLAPricing"] = "Set New Service SLA Pricing";
$strings["AttachServicesProject"] = "Attach Services to this Project (Project Management Services)";
$strings["AttachServicesTask"] = "Attach Services to this Task";
$strings["AttachServicesSOWItem"] = "Attach Services to this SOW Item";

#########################

$strings["ParentEffect"] = "Parent Effect";
$strings["SharedEffect"] = "Shared Effect";
$strings["SharedEffects"] = "Shared Effects";
$strings["SharedEffectsReport"] = "Shared Effects Report";

#########################

$strings["SIBaseUnits"] = "SI Base Units";
$strings["SIBaseUnit"] = "SI Base Unit";

#########################
/*
$strings["SideEffect"] = "Side Effect";
$strings["SideEffects"] = "Side Effects";
$strings["SideEffects"] = "Side Effects Results";
*/
$strings["SideEffect"] = "Shared Effect";
$strings["SideEffects"] = "Shared Effects";
$strings["SideEffects"] = "Shared Effects Results";
$strings["GlobalResults"] = "Global Results";

$strings["SideEffects_add_new_effect"] = "Add New Effect";
$strings["SideEffects_add_subeffect"] = "Add Sub Effect";
$strings["SideEffects_add_parenteffect"] = "Add Parent Effect";
$strings["SideEffects_VotingMessage"] = "Voting for a Side-Effect gives you a chance to express how much you believe in this and will enable clearer, speedier decisions to be made about the topic. You may also add a sub-effect or event if you believe this will be a likely result.";

#########################

$strings["SocialNetwork"] = "Social Network";
$strings["MySocialNetworks"] = "My Social Networks";
$strings["MySocialNetworkMembers"] = "My Social Network Members";
$strings["SocialNetworks"] = "Social Networks";
$strings["SocialNetworkGovernment"] = "Government Social Network";
$strings["SocialNetworkGovernment_intro"] = "Government Social Network";
$strings["SocialNetworkGovernmentType"] = "Government Type Social Network";
$strings["SocialNetworkCountry"] = "Country Social Network";
$strings["SocialNetworkPoliticalParty"] = "Political Party Social Network";
$strings["SocialNetworkMembers"] = "Social Network Members";
$strings["SocialNetworkJoin"] = "Join this Social Network to be in touch with others who share your interests, read their comments and catch the news and content that shapes your life. Have you updated your profile? You can choose what name to show for Social Networks you join. If not set - it will show as Anonymous. You can use your real name, nickname or special cloakname.";
$strings["SocialNetworkJoinedAlready"] = "You have already joined this Social Network!";
$strings["SocialNetworkSpeel"] = "Social Networks based around areas that affect your life substantially!";

$strings["SocialNetworkAbout"] = "<center><font color=#FBB117 size=5><B>".$portal_title." Social Networks</B></font></center>
<P>
<center><img src=\"../images/SocialNetworks-500x500.png\"></center>
<P>
<font size=\"3\">".$portal_title." provides a platform for a global social network based around some of the core purposes that drive people to act - privately, amongst your friends and family, as citizens, related to just you, your friends and family, your country, significant causes, events, Government, Political Parties and more.</font><P>
<font color=\"#FF8040\" size=\"3\"><B>Our goal is to provide this platform for anyone interested in socialising about substantial issues that matter to them - without borders - hopefully bringing about positive change.</B></font><P>
<font size=\"3\">We do not aim to replace other social networks - and in fact will integrate with them as there is no doubt they are an important part of the modern social fabric - and at some point, issues circulating within ".$portal_title." will touch on and find there way into other networks - for friends or business.<P>
</font>
<img src=\"images/blank.gif\" width=\"500\" height=\"20\">";

#########################

$strings["Statute"] = "Statute";
$strings["Statutes"] = "Statutes";

#########################

$strings["Structure"] = "Structure";

#########################

$strings["Ticket"] = "Ticket";
$strings["TicketSummary"] = "Ticket Summary";
$strings["TicketSummaryFull"] = "Full Summary";
$strings["TicketSummaryByDate"] = "Ticket Summary by Date";
$strings["TicketSummaryByStatus"] = "Ticket Summary by Status";
$strings["TicketSummaryActivity"] = "Ticket Activity Summary";
$strings["TicketSummaryMessage"] = "The following charts provide a summary of the tickets, status and actions.";
$strings["Tickets"] = "Tickets";
$strings["TicketStatusAssignToParent"] = "Assign Status to Parent Ticket?";
$strings["TicketStatusAssignToChildActivities"] = "Assign Status to Child Activities?";
$strings["TicketStatusAssignToChildTickets"] = "Assign Status to Child Tickets?";
$strings["TicketUserAssignToParent"] = "Assign User to Parent Ticket?";
$strings["TicketingActivity"] = "Ticketing Activity";
$strings["TicketingActivities"] = "Ticketing Activities";
$strings["TicketActivities"] = "Ticket Activities";
$strings["TicketsSystem"] = "Ticket System";
$strings["TicketCreate"] = "Create Ticket";
$strings["TicketSubmit"] = "Submit a Ticket";
$strings["SLABoundaryHit"] = "SLA Boundary Hit";
$strings["SLATicketingMessage"] = "Select the required Service SLA to attach a ticket to. Based on the time, some SLA items may not allow tickets to be attached such as 24x7 SLA when it is normal business hours in your country. You may also attach tickets to other activities or content, such as Projects, Tasks and SOW Items.";

#########################

$strings["VoIPCallOnline"] = "Call Us Online";

#########################
# General Users
#########################

$strings["UserServices"] = "User Services";

$strings["date"] = "Date";
$strings["date_custom"] = "Custom Date";

$strings["users_id"] = "ID";
$strings["users_login_name"] = "Login Name";
$strings["users_password"] = "Password";
$strings["Password"] = "Password";
$strings["FirstName"] = "First Name";
$strings["LastName"] = "Last Name";
$strings["users_fname"] = "First Name";
$strings["users_lname"] = "Last Name";
$strings["users_email"] = "Email";
$strings["Email"] = "Email";
$strings["EmailSystem"] = "Email System";
$strings["Nickname"] = "Nickname";
$strings["Cloakname"] = "Cloakname";
$strings["ProfilePhoto"] = "Profile Photo";
$strings["DefaultViewableName"] = "Default Viewable Name";
$strings["SocialNetworkViewableName"] = "Social Network Viewable Name";
$strings["FriendsViewableName"] = "Friends Viewable Name";
$strings["TwitterName"] = "Twitter User Name";
$strings["TwitterPassword"] = "Twitter Password";
$strings["LinkedInName"] = "LinkedIn User Name";

#########################
# Actions
#########################

$strings["action_add"] = "Add";
$strings["action_add_event"] = "Add Event";
$strings["action_add_media"] = "Add Media";
$strings["action_events_return"] = "Return to Events";

$strings["action_AddNew"] = "Add New";
$strings["action_addNew"] = "Add New";
$strings["action_edit"] = "Edit";
$strings["action_back"] = "Back";
$strings["action_first"] = "First";
$strings["action_last"] = "Last";
$strings["action_next"] = "Next";
$strings["action_previous"] = "Previous";
$strings["action_page"] = "Page";
$strings["action_page_of"] = "of";
$strings["action_page_of_items"] = "items";

$strings["action_addnew"] = "Add New";
$strings["action_showall"] = "Show All";
$strings["action_clicktologin"] = "Click here to log in";
$strings["action_login"] = "Login";
$strings["action_login_retrieve"] = "Retrieve";

$strings["action_logout"] = "Log Out";
$strings["action_create"] = "Create";
$strings["action_create_relationship"] = "Create Relationship";
$strings["action_update"] = "Update";
$strings["action_search"] = "Search";
$strings["action_search_keyword"] = "Keyword";
$strings["action_search_via_keyword"] = "search via keyword";
$strings["action_select"] = "Select";
$strings["action_select_fb"] = "Select to relate Facebook item";
$strings["action_select_request"] = "Please Select";
$strings["action_selectParty"] = "Select Party";

$strings["action_copy_link_share"] = "Copy the below URL and share with your contacts;";
$strings["action_copy_code_embedd"] = "Copy the below code and Embedd in any page;";

$strings["action_send_private_message"] = "Send Private Message";

$strings["action_change_language"] = "Change Language";
$strings["action_make_suggestion"] = "Make a suggestion!";
$strings["action_minimiserestore"] = "Minimize/Restore";
$strings["action_add_bookmarks"] = "Add to My Bookmarks";
$strings["action_request_ownership_transfer"] = "Request Ownership Transfer";

$strings["action_click_here_to_expand"] = "Click to expand...";
$strings["action_click_here_to_minimise"] = "Click here to minimise this window...";
$strings["action_click_here_to_openclose"] = "Click here to open/close this window...";
$strings["action_click_here_to_request"] = "Click here to make your request";
$strings["action_click_here_to_manage"] = "Click here to Manage";
$strings["action_click_here_to_clone"] = "Click here to clone";
$strings["action_click_here_to_learn_more"] = "Click here to learn more...";
$strings["action_click_here_to_try_again"] = "Click here to try again...";
$strings["action_click_here_to_retrieve"] = "Click here to retrieve...";
$strings["action_click_here_to_view_full_votes"] = "Click here to view full vote statistics";
$strings["action_click_here_to_hide_embedded"] = "Click here to hide Embedded Services";
$strings["action_click_here_to_make_news"] = "Newsmakers - Click here to MAKE News!";

$strings["action_click_to_login"] = "Click here to Log in";

$strings["action_close"] = "Close";

$strings["action_contact_owner"] = "Contact the Owner";
$strings["action_contact"] = "Contact";
$strings["action_contact_us"] = "Contact Us";
$strings["action_create_new_party"] = "Create New Party";

$strings["action_join_socialnetwork"] = "Join this Social Network";

$strings["action_post"] = "Post";

$strings["action_share_this_page"] = "Share this page!";

$strings["action_view"] = "View";
$strings["action_view_here"] = "View here..";
$strings["action_view_all"] = "View All";
$strings["action_view_event"] = "View Event";

$strings["action_Vote_for"] = "Vote for ";
$strings["action_Vote_for_this_Government"] = "Vote for this Government";
$strings["action_Vote_for_this_GovernmentType"] = "Vote for this Government Type";
$strings["action_Vote_for_this_Constitution"] = "Vote for this Constitution";
$strings["action_Vote_for_this_PoliticalParty"] = "Vote for this Political Party";
$strings["action_Vote_for_this_PoliticalPartyPolicy"] = "Vote for this Political Party Policy";
$strings["action_Vote_for_this_Organisation"] = "Vote for this Organisation";
$strings["action_Vote_for_this_OrganisationPolicy"] = "Vote for this Organisation Policy";

$strings["action_Nominate_for_this_Role"] = "Nominate for this Role";

$strings["action_send_message"] = "Send Message";

$strings["action_Share"] = "Share";

$strings["company_name"] = "Company Name";
$strings["company_sponsor"] = "Location/Event Sponsor";

$strings["country"] = "Country";

$strings["location"] = "Location";
$strings["location_name"] = "Location Name";
$strings["location_type"] = "Location Type";
$strings["location_info"] = "Location Info";
$strings["location_direction"] = "Direction";
$strings["location_number"] = "Location Number";
$strings["location_position"] = "Position";

$strings["event_name"] = "Event Name";
$strings["event_lineup"] = "Event Line-up";
$strings["event_date_start"] = "Event Start Date";
$strings["event_date_end"] = "Event End Date";
$strings["event_info"] = "Event Info";
$strings["event_map"] = "Event Map";
$strings["event_click_message"] = "Click the seat number to view content...";
$strings["event_and_locations"] = "Events & Locations";
$strings["event_see_more"] = "See below map for more events..";

$strings["categories"] = "Categories";
$strings["par_cat"] = "Parent Category";
$strings["sub_cat"] = "Sub Category";

$strings["contents"] = "Content";
$strings["contents_latest"] = "Latest Content";
$strings["content_owner"] = "Owner";
$strings["content_selected"] = "Selected Content";

// My Account

$strings["my_account"] = "My Account";

// Search

$strings["search"] = "Search";

$strings["last_year"] = "Last Year";
$strings["last_month"] = "Last Month";
$strings["yesterday"] = "Yesterday";
$strings["this_year"] = "This Year";
$strings["this_month"] = "This Month";
$strings["today"] = "Today";
$strings["clear"] = "Clear";

// View

$strings["Views"] = "Views";
$strings["view_limit"] = "View Limit";
$strings["view_current"] = "Current";

$strings["title"] = "Title";

// Synch Config
$strings["param"] = "Param";
$strings["value"] = "Value";
$strings["ValueType"] = "Value Type";
$strings["ValueTypes"] = "Value Types";
$strings["value_yes"] = "Yes";
$strings["value_no"] = "No";

// Products
$strings["products"] = "Products";

// Users
$strings["User"] = "User";
$strings["users"] = "Users";
$strings["Users"] = "Users";

// Empty Messages
$strings["Empty_Listed"] = "There are no items listed..";

// Error Messages
$strings["l_Login_Error"] = "Ooops! There seems to be a problem with your access credentials.";
$strings["l_Login_Success"] = "Correct login! Please click here..";

$strings["SubmissionErrorEmptyItem"] = "The following item can not be empty: ";
$strings["SubmissionErrorAlreadyExists"] = "The following item already exists: ";
$strings["SubmissionErrorWrongFormat"] = "The following item format is not correct: ";
$strings["SubmissionShareDefaultSubject_p1"] = "I want to share ";
$strings["SubmissionShareDefaultSubject_p2"] = " with you from ";
$strings["SubmissionThankyou"] = "Thank you for your submission: ";
$strings["SubmissionSuccess"] = "Your submission was a success! Please check it out and edit it further if need be.";
$strings["SubmissionRequired"] = " is required!";

// Email Delivery Messages
$strings["EmailDeliverySubject_Registration"] = " Account Access Information";
$strings["EmailDeliverySubject_BodyP1"] = ", you have tried to register with ";
$strings["EmailDeliverySubject_BodyP2"] = " with the following email address:";
$strings["EmailDeliverySubject_BodyP3"] = "Please use the following password to access your account:";
$strings["EmailDeliverySubject_BodyP4"] = "Enjoy using ";

// Registration Messages
$strings["RegoSubject_Registration"] = " Account Registration";
$strings["RegoFormTitle"] = "Account Registration";
$strings["NeedAnAccount"] = "Need an account?";
$strings["RegisterHere"] = "Register here..";
$strings["AccessProblems"] = "Access problems?";
$strings["RetrieveHere"] = "Retrieve here..";
$strings["RegistrationSuccess"] = "Congratulations, your account was successfully created! Please check your email for further details.";

$strings["RegisterAsProvider"] = "Register as a Provider";
$strings["RegisterAsReseller"] = "Register as a Reseller";
$strings["RegisterAsClient"] = "Register as a Client";

$strings["EmailForgottenPass_P1"] = "Checking for an account that uses ";
$strings["EmailForgottenPass_P2"] = " for authentication... ";

$strings["Login_Forgot"] = "Forgotten Password";
$strings["Login_ForgotProvideEmail"] = "Please provide your email address so we can send your password";
$strings["LoginErrorEmail"] = "Sorry, you need to input a correct email address. ";
$strings["LoginErrorEmailNoAccount"] = "Sorry, there is no such account, this email address doesn't exist in any account.";
$strings["LoginEmailSubmissionSuccess"] = "Your email address exists! Please check your email to get your password - it has been sent there.";
$strings["LoginEmailDeliveryProblem"] = "There seems to be a problem sending to this email - please check with the Administrator by contacting directly by email to: ";

// Form Messages
$strings["message_kakunin"] = "Please confirm the form data is correct and then press Continue to process..";
$strings["message_have_permission"] = "You have permission to create items, Effects, Votes, Comment and more...";
$strings["message_have_no_permission"] = "You need to Login/Register to create items, Effects, Votes, Comment and more...";
$strings["message_restricted_area"] = "The page you are trying to access is restricted. Please ask your Account Administrator for more details..";

$strings["message_create_Organisation_based_on"] = "You can create and base a new Organisation upon this one (or any other found in the top left list).";
//$strings["message_create_Organisation_scratch"] = "To start completely fresh, click on the Government or Government Type of your choice from the left section on the top page and create from there.";

$strings["message_request_to_join_administration"] = "You are logged in and the Administrators are accepting Requests to join the Administration.<P>
Please note that you need to provide a solid case and your identity can be verified by the current Administrators for them to seriously consider your request. Reasons why this feature is enabled is to allow responsible people to join in building - to make it as good as it can be - and as you can see from the existing Governments (Example: United States of America Government) - there are a lot of parts that need to be considered..";

$strings["message_request_to_join_administration_disabled"] = "The Administrators are not allowing requests to join in this Administration at this moment.";

$strings["message_required"] = "(Required)";

$strings["message_login_to_administor"] = "You are not logged-in. You must be logged in and have Administration rights to Administer or request Administration access to manage this.";

$strings["message_not_logged-in"] = "You are not logged-in.";

$strings["message_need_to_log-in-socialnetworks"] = "You need to be logged-in to be able to join this Social Network.";

$strings["message_not_logged-in_cant_add"] = "You are not logged in. You can not add any items yet...";

$strings["message_vote_edit"] = "You are free to edit your vote at any time. Your country is set based on the IP your computer showed. If you would like to change this to the IP of the country this vote relates to, please contact us with an explanation. The IP is a very important way to try to keep votes properly managed based on the real location of the voter - because we can not validate the users. Also, we understand that cloaking may be necessary - and that some people may vote while outside their country.";


// For Processed Messages
$strings["processed_Nominated"] = "Your nomination for this roles has processed succesfully. Please return to your account to see the details.";

// Notes
$strings["notes_MyGovernmentAdministration"] = "As the Administrator of Governments, you control the ultimate future, direction and success of the Government. You will decide the initial building blocks of the Government - from Branches, Branch Bodies, Departments, Agencies all the way down to Roles.
<P>
You may be an individual or a group of like-minded people - but the components you add to your Government along with the Policies of your Party will be the most important factor in how it will be accepted and embraced by the citizens.";

$strings["notes_MyPartyAdministration"] = "<img src=images/PartyButton-100x100.png><P>As the Administrator of a Political Party, you control the ultimate future, direction and success of the Party. You will be able to invite people to join your party and your party may support an existing Government - or create a new Government.
<P>
You may be an individual or a group of like-minded people - but the components you add to your Party and any Policies will be the most important factor in how it will be accepted and embraced by the citizens.
<P>
Do not confuse the Administrator of the Party as the Party Leader - although you may also be the same - however the Administrator is ultimately responsible for architecting the Party - and from there it will form a life of its own. Administrators maintain ownership and control of the Party Account Management until otherwise decided in the Party Policies.";

$strings["notes_NewGovernment"] = "To create a new Government, you must first create a Political Party. <a href=\"#BMap\" onClick=\"makePOSTRequest('Body','Body.php?do=PoliticalParty&action=new&value=&valuetype=');return false\">Click here</a> to create a new one from scratch or clone one from your favourite party (listed in the left column of the top page).";

$strings["notes_NewGovernment_Clone"] = "You have selected to create a Government based on another existing Government. This will entail cloning the various Branches, Departments, Agencies and Roles. The names will be similar - except your chosen Government Name will prefix everything. Roles will be empty - waiting to be filled. Below you will find a form that will allow you to do some initial customisations and your Government can be further edited and customised after the cloning is complete.
<P>
A benefit of cloning from an existing Government as opposed to cloning a Government Type is that it may be more complete with content such as Constitutions, Articles, Amendments, etc., available and cloned for editing later. The birth of any Government requires the inceptors to decide who will lead and how - so you as Administrator will be the Head (President/Prime Minister/Dictator), with your Party (You and your colleagues, friends, peers, tribe) acting as the initial caretaker(s) of the new-born Government. How long you stay on as the caretaker government will depend largely on the Constitution you will create.";

$strings["notes_NewGovernment_TypeClone"] = "You have selected to create a Government based on a Government Type. This will entail cloning the various Branches, Departments, Agencies and Roles. The names will be similar - except your chosen Government Name will prefix everything. Roles will be empty - waiting to be filled. Below you will find a form that will allow you to do some initial customisations and your Government can be further edited and customised after the cloning is complete.
<P>
A benefit of cloning from a Government Type as opposed to cloning a Government is that it will just have the core structure and you can build Constitutions, Articles, Amendments, etc. from scratch. The birth of any Government requires the inceptors to decide who will lead and how - so you as Administrator will be the Head (President/Prime Minister/Dictator), with your Party (You and your colleagues, friends, peers, tribe) acting as the initial caretaker(s) of the new-born Government. How long you stay on as the caretaker government will depend largely on the Constitution you will create.";

$strings["notes_RequestOwnershipTransfer"] = "Your request for ownership of this will be sent to the current Administrator of this item. Depending on the case you present, you may or may not receive ownership. After a transfer is complete, you will have complete control of the item itself and any underlying items. The Owner will be anonymous unless he or she has made their identity public.";

$strings["notes_Nominating"] = "Nominating yourself or others for a particular role is a way to first make your interest in this role known and get some immediate visibility and will be exposed to the current Administrator of this item. The role itself may have certain requirements - as outlined in the Job Description - and will be up to the Administrator of that Role to determine whether to follow-up or not. Your nomination will also become public information for others to comment upon...";

###################
# Content

include ($location."lingo/lingo-content.en.php");

#
###################

$strings["Content_Developers"] = "<center><font color=#FBB117 size=5><B>Developers - Please Support Us!</B></font></center>
<P>
<font size=\"3\">We are a small company, working hard to bring this service to the world's citizens - running on a bootstrap - hoping to add value and make some positive disruptions. As a pure business concern, Venture Capitalists may wince - but as an open community - this is the stuff dreams can be built on.</font>
<P>
<font size=\"3\"><B>Planned Releases;</B></font>
<P> 
<font size=\"3\">* Media Integrations - Release planned for 2012-04</font><BR>
<font size=\"3\">* API - Release planned for 2012-05</font><BR>
<font size=\"3\">* Jobs - RSS - Release planned for 2012-06</font><BR>
<font size=\"3\">* Embeddable Hierarchical Maps - Release planned for 2012-07</font><BR>
<P>
<font size=\"3\"><B>We need your help!</B></font>
<P>
* Mobility - iPhone & Android<BR>
* Partners - Lend us a hand to develop to make this better -sooner!
</font><P>";

$strings["Content_PrivacyPolicy"] = "<center><font color=#FBB117 size=5><B>Privacy Policy</B></font></center>
<P>
<font size=\"3\">We aim to make our service as secure as possible - to protect yours and our information. </font>
<P>
<font size=\"3\">To do this, we have made the links to any sections encrypted. Then, the pages and access to the content is further encrypted.</font>
<P>
<font size=\"3\">We also make a solid promise that we will not release your private information to any third parties - ever - without your express desire to do so.</font>
<P>
<font size=\"3\">All content is, in default, in a state of privacy. Then, if you wish to open something up to the world at large, then this setting can be changed at any time.</font><P>";

$strings["Content_TermsOfUse"] = "<center><font color=#FBB117 size=5><B>Terms Of Use</B></font></center>
<P>
<font size=\"3\">By accessing this site and service, you agree to our terms of use.</font>
<P>
<font size=\"3\">We have put considerable effort into developing this service, making it useful, valuable and most importantly - unique!</font>
<P>
<font size=\"3\">We understand that innovation often is driven by ideas, particularly after seeing something somewhere, and we are sure people will get sparks of innovation after seeing our service. All we ask is that you do not blatently copy what we are doing. To do so would basically go against our terms of service anyway - and would really be so boring of you.</font>
<P>
<font size=\"3\">We put this service into the public domain hoping to add some value and at the same time do have expectations of fair use.</font>
<P>
<font size=\"3\">We appreciate your understanding and hope you enjoy using our services.</font><P>";

?>