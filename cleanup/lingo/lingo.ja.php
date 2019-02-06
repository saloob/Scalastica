<?php
####################################################################
# Synch Lingo File
# Saloob, Inc. All rights reserved 2008+
# Author: Matthew Edmond
# Date: 2008-12-04
# URL: http://www.saloob.jp
# Email: sales@saloob.jp
####################################################################

$locale = "japanese";

$portal_title = $portal_config['portalconfig']['portal_title'];
$glb_domain = $portal_config['portalconfig']['glb_domain'];
$location = "/var/www/vhosts/".$glb_domain."/httpdocs/";
//$location = "/var/www/vhosts/default/htdocs/";

#########################
# Menu Items
#########################

$strings["About"] = "我々について";
$strings["Login"] = "サインイン";
$strings["QuickLinks"] = "クイックリンク";
$strings["Rules"] = "ルール";
$strings["Structure"] = "ストラクチャー";
$strings["Settings"] = "設定";
$strings["PrivacyPolicy"] = "プライバシーポリシー ";
$strings["TermsOfUse"] = "利用条件";
$strings["BestViewedBrowsers"] = "<center>このサイトは<a href=http://www.mozilla.org/en-US/firefox/‎target=Firefox>Firefox</a>や<a href=http://www.apple.com/safari/‎target=Safari>Safari</a>と<a href=http://www.google.com/chrome target=Chrome>Chrome</a>でよく見ることが出来ます。<BR><img src=images/BrowserTrio.png width=190></center>";

#########################
# General Lingo
#########################

$strings["phone_office"] = "オフィス電話番号";
$strings["phone_fax"] = "オフィスファックス";
$strings["website"] = "ウェブサイトURL";
$strings["billing_address_street"] = "住所：道・ビル";
$strings["billing_address_city"] = "住所：市";
$strings["billing_address_state"] = "住所：県・ステート";
$strings["billing_address_postalcode"] = "住所：郵便番号";

$strings["home"] = "トップ";
$strings["Account"] = "アカウント";

$strings["AccessLevel"] = "アクセス権利";

$strings["Administration"] = "管理";

$strings["ads"] = "広告";

$strings["affiliate_id"] = "アフィリエイトID";

$strings["AffectedGroupType"] = "グループタイプ";

$strings["Agreement"] = "このチェックボックスを選択し、このフォームを提出することにより、あなたは、このサービスを利用するための <a href=\"#\" onClick=\"loader('light');document.getElementById('light').style.display='block';doBPOSTRequest('light','Body.php', 'pc=".$portalcode."&do=Content&action=view&value=9d35be2b-7c56-9a39-b7af-540bc4ce781b&valuetype=Content&div=light');document.getElementById('fade').style.display='block';return false\"><B>利用規約</B></a>と<a href=\"#\" onClick=\"loader('light');document.getElementById('light').style.display='block';doBPOSTRequest('light','Body.php', 'pc=".$portalcode."&do=Content&action=view&value=c3593693-a0a4-c389-7d05-541ed5abdfbf&valuetype=Content&div=light');document.getElementById('fade').style.display='block';return false\"><B>「マスターサブスクリプション契約」</B></a>をご確認の上、同意される場合にはチェックをお願い致します";

$strings["Average"] = "平均";

$strings["Build"] = "ビルド";

$strings["Cancel"] = "キャンセル";

$strings["Category"] = "カテゴリー";
$strings["Categories"] = "カテゴリー";

$strings["Close"] = "閉じる";

$strings["date"] = "日付";
$strings["Date"] = "日付";
$strings["date_custom"] = "カスタム日付";
$strings["DateEnd"] = "終了日付";
$strings["DateStart"] = "開始日付";
$strings["DateCurrent"] = "現在の日付";

$strings["Facebook_MessagePost"] = "メッセージとリンクはフェイスブックにポストされます";
$strings["Facebook_MessagePostPrivate"] = "友達に直接メッセージをポストされます.";

$strings["Friend"] = "友達";
$strings["Friends"] = "友達";

$strings["ID"] = "ID番号";
$strings["Importance"] = "重要性";

$strings["Industry"] = "企業";
$strings["Industries"] = "企業の一覧";

$strings["Multiple"] = "複数";

$strings["Summary"] = "サマリー";

$strings["Time"] = "時間・タイム";
$strings["TimeDimension"] = "時間・タイムディメンション";
$strings["TimeDimensions"] = "時間・タイムディメンション";

$strings["TimeEnd"] = "終了時間";
$strings["TimeStart"] = "開始時間";

$strings["Currency"] = "通貨";
$strings["Currencies"] = "通貨";

$strings["Description"] = "内容";

$strings["GoldBlocks"] = "(金ブロック)";

$strings["Latitude"] = "緯度";
$strings["Longitude"] = "経度";

$strings["Language"] = "言語";
$strings["List"] = "一覧";

$strings["Year"] = "年";
$strings["Years"] = "年間";
$strings["Month"] = "月";
$strings["Months"] = "ヶ月";
$strings["Day"] = "日";
$strings["Days"] = "日間";
$strings["Hour"] = "時";
$strings["Hours"] = "時間";
$strings["Minute"] = "分";
$strings["Minutes"] = "分";
$strings["Second"] = "秒";
$strings["Seconds"] = "秒";

$strings["Monetary"] = "貨幣単位";

$strings["My"] = "私の";
$strings["Me"] = "私";

$strings["NA"] = "ない";

$strings["Name"] = "名前・タイトル";

$strings["or"] = "か";

$strings["OtherItems"] = "その他のアイテム";

$strings["Origin"] = "起源";
$strings["Origination"] = "発祥";

$strings["Parent"] = "親";

$strings["Population"] = "人口";
$strings["Probability"] = "蓋然性";

$strings["PercentageWarning"] = "% (フォーマット: 1, 0.98 or 0.01, など)";
$strings["DecimalWarning"] = "(フォーマット: 12.01, 0.0001, -18.11, 10000.63454, など)";
$strings["IntegerWarning"] = "(フォーマット: 12, 0, -18, 10000, など)";
$strings["DateTimeWarning"] = "(フォーマット: 2011-12-28 21:56)";

$strings["Positivity"] = "陽性";
$strings["Purpose"] = "目的/動機";
$strings["Purposes"] = "目的/動機";

$strings["Quantity"] = "量";
$strings["QuickStats"] = "クイック統計";

$strings["Recipients"] = "受信者";

$strings["Related"] = "関連";
$strings["RelatedContent"] = "関連したコンテンツ";
$strings["RelatedTypes"] = "関連したタイプ";

$strings["RelatedAccount"] = "関連アカウント";
$strings["RelatedAccountSharing"] = "関連アカウントの共有";

$strings["Return"] = "戻る";

$strings["Register"] = "登録";
$strings["Register_Info"] = "<B>口座を作ることは簡単です－我々は始まるためにちょうど4ビットの情報を必要とします。</B><P>
「＊」に書かれているフィールドは必須です。<P>";

$strings["Required"] = "必須";
$strings["RequiredMessage"] = "アステリスク（＊）は必ず入力してください。";

$strings["Score"] = "スコア";
$strings["Scores"] = "スコア";
$strings["Score(s)"] = "スコア";
$strings["PublicStatus"] = "公開ステータス";
$strings["Status"] = "ステータス";
$strings["Subject"] = "件";
$strings["Title"] = "タイトル";
$strings["Total"] = "合計";

$strings["Update"] = "アップデート";
$strings["Updates"] = "アップデートの一覧";

$strings["Urgency"] = "緊急";
$strings["Urgent"] = "緊急";

$strings["You"] = "貴方";
$strings["Your"] = "貴方の";

$strings["Venue"] = "場所";

$strings["CompletionRate"] = "完遂率";
$strings["Completed"] = "完了";
$strings["Link"] = "リンク";
$strings["LinkExternal"] = "外部リンク";

#########################
# Shared Effects
#########################

$strings["Action"] = "行動・アクション";
$strings["Actions"] = "アクション";
$strings["ActionsPublic"] = "公開アクション";

$strings["ParentEffect"] = "親エフェクト";

$strings["Effect"] = "共有影響・エフェクト";
$strings["Effects"] = "共有影響・エフェクト";
$strings["Emotion"] = "情動・イモーション";
$strings["Emotions"] = "情動・イモーション";

$strings["FinalReport_PositiveValueOf"] = "ポジティブな価値 ";
$strings["FinalReport_NegativeValueOf"] = "ネガティヴな価値 ";
$strings["FinalReport_AccordingToThe"] = "According to the ";
$strings["FinalReport_EffectsSubmitted"] = " shared side-effect(s) submitted, having ";
$strings["FinalReport_GroupTypes"] = " unique Group Type(s) potentially affected, ";
$strings["FinalReport_PeopleBelieve"] = " people believe there is a ";
$strings["FinalReport_PersonBelieves"] = " person believes there is a ";
$strings["FinalReport_Probability"] = "% probability that ";
$strings["FinalReport_WillHaveAnAverage"] = " will have an average ";
$strings["FinalReport_SeeBelow"] = "See below for the full report breakdown. The average level of POSITIVITY of each item will determine the scale colour and the (+/-) number. The positivity is a subjective, yet valuable number, as it shows the overal positive vibes that the group is feeling about this.";

$strings["VoteReport_AccordingToThe"] = "According to the ";
$strings["VoteReport_VotesSubmitted"] = " vote(s) submitted, ";
$strings["VoteReport_PeopleBelieve"] = " people believe the average positivity is ";
$strings["VoteReport_PersonBelieves"] = " person believes the average positivity is ";
$strings["VoteReport_ForThis"] = " for this item.";
$strings["VoteReport_SeeBelow"] = "See below for the full report breakdown.";

#########################

$strings["Accounts"] = "アカウント";
$strings["ParentAccount"] = "親アカウント";
$strings["PersonalAccount"] = "個人のアカウント";
$strings["PersonalDetails"] = "個人のアカウントの詳細";
$strings["PersonalDetailsUpdate"] = "個人のアカウントの情報を変更するのが　";
$strings["Account"] = "アカウント";
$strings["AccountDetails"] = "アカウントの詳細";
$strings["AccountName"] = "アカウント名";
$strings["AccountRelationship"] = "アカウント関連";
$strings["AccountRelationships"] = "アカウント関連";
$strings["AccountRelationshipDetails"] = "企業は、情報、サービスを共有し、一緒に様々な活動を実行するためのアカウントの関係は、そのような管理プロジェクト、タスク、アカウント管理、完全なチケットや活動など、許可する。";

#########################

$strings["Administrators"] = "管理者";

#########################

$strings["Advisory"] = "アドバイザリー";
$strings["AdvisorySettings"] = "アドバイザリー設定";
$strings["AdvisoryCharacter"] = "アドバイザリーキャラクター";
$strings["AdvisoryIntro"] = "<B>アドバイザリーへようこそ。</B><BR>こちらで、使いやすい情報、アイデアなどの関連情報を提供して貴方の仕事を協力します。";
$strings["AdvisoryWelcomeBack"] = "XXXXXX様、お帰り。ただ今、何かお手伝うことがありますか？";
$strings["AdvisoryWelcomeFriend"] = "ようこそ！お手伝うことを頑張ります。。";
$strings["AdvisoryMemberClickToViewAdvisory"] = "XXXXXX様、クリックしてアドバイザリーセクションに飛びます。。";
$strings["AdvisoryFriendClickToViewAdvisory"] = "クリックしてアドバイザリーセクションに飛びます。。";

#########################

$strings["Agencies"] = "外局・エージェンシー";
$strings["Agent"] = "エージェント";
$strings["AgencyTenders"] = "外局・エージェンシーのテンダー・RFP";

#########################

$strings["Anonymous"] = "匿名";
$strings["AnonymousUser"] = "匿名ユーザ";

#########################

$strings["Article"] = "記事";
$strings["Articles"] = "記事";

#########################

$strings["Billing"] = "課金";

#########################

$strings["BusinessAccount"] = "ビジネスアカウント";
$strings["BusinessAccounts"] = "ビジネスアカウント";

#########################

$strings["Call"] = "コール";
$strings["CallTree"] = "コール・ツリー";
$strings["CallTrees"] = "コール・ツリーの一覧";
$strings["Calls"] = "コールの一覧";
$strings["CallLogs"] = "コール・ログ";

#########################

$strings["Cause"] = "原因・コーズ";
$strings["Causes"] = "原因・コーズ";
$strings["Causes_Content_Short"] = "原因は、あなたにとって多くを意味する問題と協調してもつ利害関係のある市民（あなた！）の重要な拠り所です。
原因は、複数のイベントを催すことができます。 ";
$strings["Causes_Content_Long"] = "原因は、GovernmentsとPolitical双方 ― 市民抗議の普通のもと ― または支持から確立されることができます。単にあなたの目的を加えて、それをあなたの友人と共有して、いくらかの活動を行くようにし始められます。あなたが原因の正と負の副作用を予測するか、記録するようにするために仲間の市民と協力することができるように、我々は共有影響も加えました。";

#########################

$strings["ChildSystem"] = "チャイルドシステム";

#########################

$strings["Comments"] = "コメント";
$strings["Comment"] = "コメント";
$strings["MyComments"] = "私のコメント";
$strings["CommentAnonymous"] = "匿名のコメント";

#########################
# Configuration Items

$strings["ConfigurationItemParent"] = "コンフィグレーションアイテム親";
$strings["ConfigurationItem"] = "コンフィグレーションアイテム";
$strings["ConfigurationItems"] = "コンフィグレーションアイテムの一覧";
$strings["ConfigurationItemsMessage"] = "CI「コンフィグレーションアイテム」は我々のデータを形にしたり、サービスを管理されたりするの大事なデータアイテムです。CIはサービス、サービスSLAリクエスト、プロジェクトやチケットに付けられたて、コールツリーやインベントリーやサービス資産などの必要な情報となります。例としては、お客様のインシデントやリクエストを対応する際、エスカレーションのための必須なコールツリーはCIでご用意できます。チケットをもっと効率的に管理するために、当コールツリーセットをひとつでも複数サービスSLAリクエストに連携できます。";
$strings["RelatedConfigurationItems"] = "関連コンフィグレーションアイテムの一覧";
$strings["ConfigurationItemType"] = "コンフィグレーションアイテムタイプ";
$strings["ConfigurationItemTypes"] = "コンフィグレーションアイテムタイプの一覧";
$strings["RelatedConfigurationItemTypes"] = "関連コンフィグレーションアイテムタイプの一覧";
$strings["ConfigurationItemSets"] = "コンフィグレーションアイテムのセット";
$strings["ExternalSystemsConfiguration"] = "外部システム";
$strings["InfraConfiguration"] = "インフラストラクチャー";
$strings["SystemConfiguration"] = "システムのコンフィグレーション";
$strings["PortalConfiguration"] = "ポータルのコンフィグレーション";
$strings["DataCenter"] = "データセンター「DC」";
$strings["DataCenters"] = "データセンターの一覧「DCs」";
$strings["DCFloor"] = "DCフロア「階」";
$strings["DCFloors"] = "DCフロアの一覧「階」";
$strings["CI_Rack"] = "ラック";
$strings["CI_Racks"] = "ラックの一覧";
$strings["CI_System"] = "システム";
$strings["CI_RackUnitSpace"] = "ラック・ユーニット・スペース";
$strings["CI_RackServerUnit"] = "ラック・サーバ・ユーニット";
$strings["CI_Blade"] = "ブレード";
$strings["CI_Blades"] = "ブレードの一覧";
$strings["CI_BladeChasis"] = "ブレードのシャシー";
$strings["CI_Server"] = "サーバ";
$strings["CI_ServerStatus"] = "サーバステータス";
$strings["CI_ServerStatusOnline"] = "オンライン";
$strings["CI_ServerStatusOffline"] = "オフライン";
$strings["CI_ServerStatusMaintenance"] = "メインテナンス";
$strings["CI_ServerStatusBackup"] = "バックアップ";
$strings["CI_Servers"] = "サーバの一覧";
$strings["CI_Host"] = "ホースト";
$strings["CI_Hosts"] = "ホーストの一覧";

#########################

$strings["Contact"] = "連絡先";
$strings["Contacts"] = "アドレス帳";

#########################

$strings["Countries"] = "国";
$strings["Country"] = "国";
$strings["CountryCapital"] = "国の首都";
$strings["CountryPopulation"] = "国の人口";

#########################

$strings["Content"] = "コンテンツ";
$strings["ContentType"] = "コンテンツタイプ";
$strings["PortalContentType"] = "ポータルのコンテンツタイプ";
$strings["Image"] = "画像";
$strings["Images"] = "画像";
$strings["ImageUploadCompleteRefresh"] = "アップロードが完了。上記のXXXXリンクをクリックしたらページをリロードできます。。";
$strings["ImageThumbnail"] = "画像のサムネールl";
$strings["ImageThumbnailURL"] = "サムネールのURL";
$strings["Thumbnail"] = "サムネール";
$strings["GalleryImage"] = "画像ギャラリー";
$strings["MediaType"] = "メディアタイプ";
$strings["MediaTypes"] = "メディアタイプ";
$strings["MediaSource"] = "メディアソース";
$strings["HTMLEditorShow"] = "HTMLエディターを表示";
$strings["HTMLEditorHide"] = "HTMLエディターを隠す";
$strings["HTMLEditorCopyMessage"] = "エディターのソースボタンを選択したら下記のテキストボックスにソースをコピーできます。";

#########################

$strings["Credits"] = "クレジット";

#########################

$strings["Dashboard"] = "ダッシュボード";
$strings["DashboardReturn"] = "ダッシュボードに戻る";

#########################

$strings["Departments"] = "部門";
$strings["Department"] = "部門";
$strings["DepartmentRoles"] = "部門ロール";
$strings["DepartmentAgencies"] = "部門の外局";

#########################

$strings["Developers"] = "開発者";
$strings["DevelopersIntroShort"] = "開発者！我々はあなたの手助けにより大きなレベルに対するこのサービスをとってもらいたいです－それが属する ― 市民の手において ― 政府を置いてください。";

#########################

$strings["Ethics"] = "（政治）倫理";

#########################

$strings["FeeType"] = "フィータイプ";
$strings["FeeTypes"] = "フィータイプ";

#########################

$strings["Email"] = "電子メール";
$strings["Emails"] = "電子メールの一覧";
$strings["EmailExtraAddressees"] = "追加受信者（カマ,で分ける）";
$strings["EmailLogs"] = "電子メールのログ";
$strings["EmailConvertToTicket"] = "チケットを作成";
$strings["EmailFiltering"] = "メール・フィルター";
$strings["EmailFilterRecipient"] = "メール・フィルター・受信者";
$strings["EmailFilterRecipients"] = "メール・フィルター・受信者の一覧";
$strings["EmailFilterSet"] = "メール・フィルター・セット";
$strings["EmailFilterSets"] = "メール・フィルター・セットの一覧";
$strings["EmailFilterSender"] = "メール・フィルター・送信者";
$strings["EmailFilterString"] = "メール・フィルター・ストリング";
$strings["EmailFilterTemplate"] = "メール・フィルター・テンプレート";
$strings["EmailFilterTemplates"] = "メール・フィルター・テンプレートの一覧";
$strings["EmailFilterTrigger"] = "メール・フィルター・トリガー";
$strings["EmailFilterTriggers"] = "メール・フィルター・トリガーの一覧";

$strings["EmailRecipient"] = "メール・受信者";
$strings["EmailRecipients"] = "メール・受信者の一覧";
$strings["EmailTemplate"] = "メール・テンプレート";
$strings["EmailTemplates"] = "メール・テンプレートの一覧";

#########################

$strings["Event"] = "イベント";
$strings["Events"] = "イベント";
$strings["Events_Usage"] = "イベントはすべてのどんな行動でもありえます－現れてください、さもなければ、過ぎて－それはあなたが興味がある若干の地域に関するものです。イベントは、出生、死、逮捕、侵入、抗議、リリース ― 歴史のどんなイベントでも ― でありえました。イベントは原因（コーズ）と異なります－原因が多くのイベントを催すことができるという点で－例えば、並列は独裁者を倒すために原因のために抗議します。";
$strings["MyEvents"] = "私のイベント";
$strings["EventsCreate"] = "イベントを作って、フェイスブックの上に書き込みしましょう！";

#########################

$strings["FAQ"] = "FAQ";
$strings["FrequentlyAskedQuestions"] = "よくあるご質問";

#########################

$strings["File"] = "ファイル";
$strings["Files"] = "ファイルの一覧";
$strings["UploadFile"] = "ファイルアップロード";

#########################

$strings["Filter"] = "フィルター";
$strings["Filters"] = "フィルターの一覧";
$strings["FilterDayRange"] = "曜日レーンジのフィルター";
$strings["FilterDateRange"] = "日付レーンジのフィルター";
$strings["FilterTimeRange"] = "時間レーンジのフィルター";
$strings["FilterDateTimeConcat"] = "日付+時間コンキャットのフィルター";
$strings["FilterSet"] = "フィルター・セット";
$strings["FilterSets"] = "フィルター・セットの一覧";
$strings["FilterString"] = "フィルター・ストリング";
$strings["FilterStrings"] = "フィルター・ストリングの一覧";
$strings["FilterCreateTicket"] = "チケットを作成";
$strings["FilterCreateActivity"] = "アクティビティーを作成";
$strings["FilterSendEmail"] = "メールを送信";
$strings["FilterAutoReplyToSender"] = "送信者に自動的に返事する";
$strings["FilterTriggerStringSubjectOnly"] = "件名にあるストリングでフィルター";
$strings["FilterTriggerStringBody"] = "メッセージにあるストリングでフィルター";
$strings["FilterTriggerStringBodyMultipleAnyOK"] = "メッセージにある複数ストリングでフィルター（どちらもOK）";
$strings["FilterTriggerStringSubjectExactMatchOnly"] = "件名にあたるストーリングでフィルター";
$strings["FilterTriggerSenderStringSubjectExactMatch"] = "送信者と件名にのあたストリングでフィルター";
$strings["FilterTriggerSenderStringBodyMatch"] = "送信者とメッセージにあたるストリングでフィルター";
$strings["FilterTriggerSenderEmailOnly"] = "送信者でフィルター";
$strings["FilterTriggerNoMatchCatchAll"] = "マッチ無しキャッチオール";
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

$strings["GovernmentLevels"] = "政府のレベル";
$strings["NoRecordedLevels"] = "レベルがない";

#########################

$strings["Government"] = "政府";
$strings["Governments"] = "政府";
$strings["VirtualGovernments"] = "仮想的な政府";
$strings["RecognisedGovernments"] = "認められた政府";
$strings["GovernmentCreate"] = "政府を作成";
$strings["GovernmentManage"] = "政府を管理";

#########################

$strings["GovernmentTypes"] = "政府タイプ";
$strings["GovernmentType"] = "政府タイプ";

#########################

$strings["GovernmentStates"] = "政府州";
$strings["StateGovernment"] = "政府州";
$strings["GovernmentState"] = "政府州";
$strings["States"] = "州";
$strings["State"] = "州";

#########################

$strings["Roles"] = "役割";
$strings["RolesNumber"] = "役割の数";

#########################

$strings["GroupType"] = "グループタイプ";
$strings["GroupTypes"] = "グループタイプ";

#########################

$strings["Integrations"] = "サービス統合";
$strings["Integrations_Right"] = "<font size=2>我々は、現在以下のサービスと統合されます;</font><P>
<font size=2><B>Facebook</B> - 強化された個人の社会的な協同のために</font><BR>
<font size=2><B>LinkedIn</B> - 強化されたプロ社会的な協同のために</font><BR>
<font size=2><B>SugarCRM</B> - 強化されたビジネス活動協同のために</font><P>
<font size=2>我々は、これらの研究その他にサービスのあなたのために最も便利で価値ある社会的な協同サービス、あなたの友人、家族と仲間になり続けます。</font>";

#########################

$strings["TopSearchedKeywords"] = "一番検索されたキーワード";

########################

$strings["Industry"] = "企業";

#########################

$strings["Language"] = "言語";
$strings["Languages"] = "言語";

#########################

$strings["TheLobby"] = "ザロビー";
$strings["Lobby"] = "ロビー";
$strings["Lobbyists"] = "ロビイスト";
$strings["LobbyistsIntroShort"] = "ロビーは、ロビイスト専用のセクションです。";

#########################

$strings["Location"] = "ロケーション";
$strings["Locations"] = "ロケーション";

#########################

$strings["Message"] = "メッセージ";
$strings["ParentMessage"] = "親メッセージ";
$strings["Messages"] = "メッセージ";
$strings["MembersMessages"] = "メンバーのメッセージ";
$strings["MessageReply"] = "メッセージを返事";
$strings["MessageRead"] = "メッセージを読まれた";
$strings["MessageUnread"] = "メッセージを読まれてない";
$strings["MessageReplied"] = "メッセージを返事された";
$strings["MessageRecipient"] = "受信者";
$strings["MessageRecipientAccount"] = "受信のアカウント";
$strings["MessageSender"] = "送信者";
$strings["MessageSenderAccount"] = "送信者のアカウント";

#########################

$strings["News"] = "ニュース";
$strings["NewsType"] = "ニュースタイプ";
$strings["NewsTypes"] = "ニュースタイプ";
$strings["NewsCategory"] = "ニュースカテゴリー";
$strings["NewsCategories"] = "ニュースカテゴリー";

#########################

$strings["Nominations"] = "ノミネート";
$strings["Nominee"] = "ノミネート候補者";
$strings["Nominees"] = "ノミネート候補者";
$strings["NominationsForRole"] = "ロールのノミネート";

#########################

$strings["SourceObjects"] = "ソースオブジェクト";
$strings["SourceObjects_Usage"] = "ソースオブジェクトは、あなたがここで使用したいあなた自身のアプリケーションのアイテムの名前です。<BR>
たとえば、SugarCRMを使いたくて、我々のサービスをオポチュニティーを自動抽出してもらいたいならば、あなたはオブジェクト『オポチュニティー』を登録しなければなりません－そして、あなたのSugarCRMアクセス情報が正しいならば、我々は協同のためにここの使用にあなたのオポチュニティーを集めることができます。";

$strings["ExternalSourceType"] = "外部のソース・タイプ";

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

$strings["Opportunity"] = "オポチュニティー";
$strings["Opportunities"] = "オポチュニティーの一覧";

#########################

$strings["Organisations"] = "組織";
$strings["Organisation"] = "組織";
$strings["OrganisationRoles"] = "組織のロール";
$strings["OrganisationPolicies"] = "組織のポリシー";
$strings["OrganisationCreate"] = "組織を作成";
$strings["OrganisationManage"] = "組織を管理";
$strings["OrganisationManageYouAreAdmin"] = "貴方はこの組織の管理者です。";

#########################

$strings["Policy"] = "ポリシー";
$strings["Policies"] = "ポリシー";

#########################

$strings["AccountInformation"] = "アカウント情報";
$strings["AccountType"] = "アカウントのタイプ";
$strings["AccountTypeProviderPartner"] = "プロバイダーパートナー";
$strings["AccountServiceProvider"] = "サービス提供者";
$strings["AccountTypeResellerPartner"] = "リセラーパートナー";
$strings["AccountTypeCustomer"] = "お客様";
$strings["MyAccount"] = "私のアカウント";
$strings["WorkArea"] = "ワーク場所";
$strings["Donations"] = "寄付";
$strings["TopVotes"] = "最高の得票";
$strings["PopularPeopleRoles"] = "人気の人々とロールス";  
$strings["MyVotes"] = "私の得票";
$strings["Vote"] = "得票";
$strings["Votes"] = "得票";
$strings["ViewFullVotes"] = "完全な票統計：";

#########################

$strings["Journalists"] = "ジャーナリスト";
$strings["Journalists_Info"] = "ジャーナリストは政府の尊重された報道を提供するために全く不可欠であると、我々が考えたUsersの特別なカテゴリーです。そして、部、エージェンシー、人々、行動と活動が世界で続きます。
ジャーナリストとして出会うことは、招待のそばにだけあります ― 既存のジャーナリストによって。";

#########################

$strings["RequestOwnershipTransfer"] = "登録換え請求";

$strings["Hierarchical_Map"] = "階層的な地図";
$strings["Hierarchical_Map_Info"] = "The Hierarchical Map below represents the various levels within this Government/Type all the way down to the roles. If you click on a Government Type, you can see similar maps but with just the structure provided for that government type. To be able to interact with the map, such as nominating yourself or others or applying for any particular roles - you need to be logged-in.";

#########################

$strings["Law"] = "法律";
$strings["LawCase"] = "法律ケース";
$strings["LawCases"] = "法律ケース";
$strings["Laws"] = "法律";
$strings["LawsCreate"] = "法律を作成";

#########################

$strings["MTV"] = "メディアTV";

#########################

$strings["Members"] = "メンバー";
$strings["Member"] = "メンバー";
$strings["MemberProfile_Note"] = "あなたのプロフィールを更新することについてのメモ。するコメントと他の提出物のためにどんな名前を示すべきかについて、あなたは選ぶことができる－ならびに、Social Networksのために、あなたは出会います。設定されないならば－と、それはアノニマスとして示します。あなたは、本当の名前、あだ名または特別なクローク名を使うことができます。";

#########################

$strings["NotificationContacts"] = "お知らせ受信者";
$strings["NotificationContactsSet"] = "受信者を設定";

#########################

$strings["Portal"] = "ポータル";
$strings["PortalSignature"] = "素晴らしい日を過ごしてください！";

#########################

$strings["ManageProject"] = "プロジェクトを管理";
$strings["Project"] = "プロジェクト";
$strings["Projects"] = "プロジェクトの一覧";
$strings["ProjectTask"] = "プロジェクトタスク";
$strings["ProjectTaskSummary"] = "プロジェクトタスクサマリー";
$strings["TaskSummaryByDate"] = "タスクサマリー「日付」";
$strings["TaskSummaryByStatus"] = "タスクサマリー「ステータス」";
$strings["ProjectTasks"] = "プロジェクトタスクの一覧";
$strings["ProjectProcess"] = "プロジェクトプロセス";
$strings["RelatedProject"] = "関連プロジェクト";
$strings["RelatedProjects"] = "関連プロジェクトの一覧";
$strings["RelatedTasks"] = "関連タスクの一覧";
$strings["ParentTask"] = "親タスク";
$strings["TaskNumber"] = "タスク番号";

$strings["predecessors"] = "先輩";
$strings["date_start"] = "開始日付";
$strings["date_finish"] = "終了日付";
$strings["time_start"] = "開始時間";
$strings["time_finish"] = "終了時間";
$strings["AccumulatedMinutes"] = "作業時間（分）";
$strings["duration"] = "存続(期間)";
$strings["duration_unit"] = "存続(期間)単位";
$strings["percent_complete"] = "完了した％";
$strings["date_due"] = "返納期日";
$strings["time_due"] = "返納期時";
$strings["parent_task_id"] = "親タスク";
$strings["assigned_user_id"] = "割り当てられたユーザー";
$strings["modified_user_id"] = "変更されたユーザー";
$strings["priority"] = "プライオリティー";
$strings["created_by"] = "作成者";
$strings["milestone_flag"] = "マイルストーンのフラグ";
$strings["order_number"] = "順番";
$strings["estimated_effort"] = "推定された努力";
$strings["actual_effort"] = "実際の努力";
$strings["deleted"] = "削除された";
$strings["utilization"] = "利用";

#########################

$strings["ITILStage"] = "ITILのステージ";
$strings["ITILStageProcess"] = "ITILのプロセス";
$strings["ServiceOperationProcess"] = "サービスオペレーションのプロセス";

#########################

$strings["Search"] = "検索";
$strings["SearchMessage"] = "以下にはキーワード：XXXXXXで検索された結果です。";

#########################

$strings["Security"] = "セキュリティー";
$strings["Access"] = "アクセス";
$strings["Role"] = "ロール";
$strings["Roles"] = "ロールの一覧";
$strings["Module"] = "モジュール";
$strings["Modules"] = "モジュールの一覧";
$strings["Import"] = "インポート";
$strings["Export"] = "エクスポート";
$strings["Edit"] = "編集";
$strings["Delete"] = "削除";
$strings["Create"] = "作成";
$strings["ViewDetails"] = "詳細を拝見";
$strings["ViewList"] = "一覧を拝見";
$strings["SecurityLevel"] = "セキュリティーレベル";
$strings["SecurityItemType"] = "セキュリティーアイテムタイプ";

#########################

$strings["SOW"] = "SOW （作業表明書）";
$strings["SOWItem"] = "SOWアイテム";
$strings["SOWItemParent"] = "親SOWアイテム";
$strings["SOWItems"] = "SOWアイテムの一覧";

#########################

$strings["Resource"] = "リソース";
$strings["Capacity"] = "キャパシティー";
$strings["ResourcesCapacity"] = "リソースキャパシティー";
$strings["Resources"] = "リソース";

#########################

$strings["Rules"] = "ルール";

#########################
# Services

$strings["AccountServices"] = "アカウントのサービス一覧";
$strings["AccountsServices"] = $strings["AccountServices"];
$strings["AccountServicesSLA"] = "アカウントのサービス一のSLA";
$strings["AccountsServicesSLA"] = $strings["AccountServicesSLA"];
$strings["AccountServicesSLAs"] = "アカウントのサービスのSLA一覧";
$strings["AccountsServicesSLAs"] = $strings["AccountServicesSLAs"];
$strings["CatalogService"] = "カタログのサービス";
$strings["CatalogServices"] = "カタログのサービス一覧";
$strings["CatalogServicesSLA"] = "カタログのサービスのSLA";
$strings["CatalogServicesSLAs"] = "カタログのサービスのSLA一覧";
$strings["CatalogServicesAddTo"] = "サービスカタログに追加";
$strings["BaseService"] = "ベースサービス";
$strings["BaseServices"] = "ベースサービス一覧";
$strings["Service"] = "サービス";
$strings["ServicesProvider"] = "サービス提供社";
$strings["Services"] = "サービス一覧";
$strings["ServicesManagement"] = "サービス管理";
$strings["ServiceSLA"] = "サービスのSLA";
$strings["ServiceSLAs"] = "サービスのSLA一覧";
$strings["ServiceSLARequest"] = "サービスとSLAをリクエスト";
$strings["ServiceSLARequestMessage"] = "こちらで、サービスのSLAをリクエストできます。登録したリクエストの中にはチケットとアクティビティーが作成されるプレースホールダーとして存在します。チケットは実際の提供しているチャージされるサービスですし、SLAタイミングもチケットの作成の時期に開始します。
<P>
プロジェクト、タスクおよびSOW項目を設定すると、より良い資源配分と分類のために作成したとき、これらの項目が自動的にチケットを設定することが可能になります。";
$strings["ServiceSLARequests"] = "サービスとSLAのリクエスト";
$strings["SetServiceSLAPricing"] = "サービスとSLAの価格の設定";
$strings["SLAManagement"] = "SLA管理";
$strings["ServiceSLAManagement"] = "サービスのSLA管理";
$strings["ServiceSLAPrices"] = "サービスSLAの価格";
$strings["ServiceSLAPrice"] = "サービスSLAの価格";
$strings["ServicesPricing"] = "サービス価格の設定";
$strings["ServicesPrices"] = "サービスの価格";
$strings["ServicesPrices_RequireLogin"] = "サービスのリクエストは価格による出来ますが、サインインが必要です。";
$strings["SetNewServiceSLAPricing"] = "新規サービスのSLAを設定";
$strings["AttachServicesProject"] = "プロジェクトにサービスを付る（プロジェクト管理サービス）";
$strings["AttachServicesTask"] = "タスクにサービスを付る";
$strings["AttachServicesSOWItem"] = "SOWアイテムにサービスを付る";

#########################

$strings["ParentEffect"] = "親影響";
$strings["SharedEffect"] = "共有影響";
$strings["SharedEffects"] = "共有影響";
$strings["SharedEffectsReport"] = "共有影響報告";

#########################

$strings["SIBaseUnits"] = "SI ベース単位";
$strings["SIBaseUnit"] = "SI ベース単位";

#########################
/*
$strings["SideEffect"] = "Side Effect";
$strings["SideEffects"] = "Side Effects";
$strings["SideEffects"] = "Side Effects Results";
*/
$strings["SideEffect"] = "共有影響";
$strings["SideEffects"] = "共有影響";
$strings["SideEffects"] = "共有影響の結果";
$strings["GlobalResults"] = "グローバル結果";

$strings["SideEffects_add_new_effect"] = "新規影響を挿入";
$strings["SideEffects_add_subeffect"] = "サブ影響を挿入";
$strings["SideEffects_add_parenteffect"] = "親影響を挿入";
$strings["SideEffects_VotingMessage"] = "Side-Effectのための投票は、あなたにあなたがこれでいくらを信じているかについて表す機会を与えて、よりはっきりした、より速やかな決定が話題についてなされるのを可能にします。これがありそうな結果であると思っているならば、あなたは下位影響またはイベントも加えるかもしれません。";

#########################

$strings["SocialNetwork"] = "ソーシャルネットワーク";
$strings["MySocialNetworks"] = "私のソーシャルネットワーク";
$strings["MySocialNetworkMembers"] = "私のソーシャルネットワークのメンバー";
$strings["SocialNetworks"] = "ソーシャルネットワーク";
$strings["SocialNetworkGovernment"] = "政府のソーシャルネットワーク";
$strings["SocialNetworkGovernment_intro"] = "政府のソーシャルネットワーク";
$strings["SocialNetworkGovernmentType"] = "政府のタイプのソーシャルネットワーク";
$strings["SocialNetworkCountry"] = "国のソーシャルネットワーク";
$strings["SocialNetworkPoliticalParty"] = "政治党のソーシャルネットワーク";
$strings["SocialNetworkMembers"] = "ソーシャルネットワークのメンバー";
$strings["SocialNetworkJoin"] = "あなたの利益を共有する他と接触して、彼らのコメントを読んで、あなたの人生を形づくるニュースと内容を捕えるために、このソーシャルネットワークに加わってください。あなたは、プロフィールを更新しましたか？設定されないならば－と、それはアノニマスとして示します。あなたは、本当の名前、あだ名または特別なクローク名を使うことができます。";
$strings["SocialNetworkJoinedAlready"] = "あなたは、この社会的ネットワークにすでに加わりました！";
$strings["SocialNetworkSpeel"] = "大幅にあなたの人生に影響を及ぼす地域のまわりで、社会的ソーシャルネットワークは基づきました！";

$strings["SocialNetworkAbout"] = "<center><font color=#FBB117 size=5><B>".$portal_title." ソーシャルネットワーク</B></font></center>
<P>
<center><img src=\"../images/SocialNetworks-500x500.png\"></center>
<P>
<font size=\"3\">".$portal_title." 人々を行動するようにする ― 個人的に、国民として、あなたの友人と家族の間にちょうどあなた、あなたの友人と家族、あなたの国、有意な原因、イベント、政府、政治党とより多くに関するものだった ― 中心的な目的のいくらかのまわりに拠点を置く世界的な社会的ネットワークに、これはプラットホームを提供します。</font><P>
<font color=\"#FF8040\" size=\"3\"><B>彼らに相当な問題についてその問題を社会化することに興味がある誰にでも、我々のゴールはこのプラットホームを与えることになっています ― 境界なしで。そして、うまくいけばポジティブな変化をもたらします。</B></font><P>
<font size=\"3\">我々は他の社会的ネットワークに代わろうとしません－そして、彼らが現代の社会機構の重要な部分であるという疑いがなくて、事実は彼らと中で融和します－そして、数ポイントで、".$portal_title."の中で回っている問題は進行中の感じがして、他のネットワークにずっとそこで見つけます ― 友人またはビジネスのために。<P>
</font>
<img src=\"images/blank.gif\" width=\"500\" height=\"20\">";

#########################

$strings["Statute"] = "法令";
$strings["Statutes"] = "法令";

#########################

$strings["Structure"] = "ストラクチャー";

#########################

$strings["Ticket"] = "チケット";
$strings["TicketSummary"] = "チケットのサマリー";
$strings["TicketSummaryFull"] = "全体的なサマリー";
$strings["TicketSummaryByDate"] = "日付でソートされたチケットサマリー";
$strings["TicketSummaryByStatus"] = "ステータスでソートされたチケットサマリー";
$strings["TicketSummaryActivity"] = "チケットアクティビティーのサマリー";
$strings["TicketSummaryMessage"] = "下記のチャートはチケットのステータスやアクションなどのサマリーです。";
$strings["Tickets"] = "チケットの一覧";
$strings["TicketStatusAssignToParent"] = "親チケットに同じステータスを決定？";
$strings["TicketStatusAssignToChildActivities"] = "チャイルドアクティビティーチケットに同じステータスを決定？";
$strings["TicketStatusAssignToChildTickets"] = "チャイルドチケットに同じステータスを決定？";
$strings["TicketUserAssignToParent"] = "親チケットに同じユーザを決定？";
$strings["TicketingActivity"] = "チケットアクティビティー";
$strings["TicketingActivities"] = "チケットアクティビティー";
$strings["TicketActivities"] = "チケットアクティビティー";
$strings["TicketsSystem"] = "チケットのシステム";
$strings["TicketCreate"] = "チケットを作成";
$strings["TicketSubmit"] = "チケットを作成";
$strings["SLABoundaryHit"] = "SLA以外";
$strings["SLATicketingMessage"] = "必要なSLAを選択してチケットを付けられます。時間による、幾つかのSLAアイテムにチケットを付けられない場合もあります。例：朝の9時から5時までの間の24x7様なSLAアイテムに付けられないです。その他のアクティビティーにチケットを付けられます。例：プロジェクト、タスク、SOWアイテム、など。";

#########################

$strings["VoIPCallOnline"] = "オンラインで無料の電話";

#########################
# General Users
#########################

$strings["UserServices"] = "ユーザ・サービス";

$strings["date"] = "日付";
$strings["date_custom"] = "カスタム日付";

$strings["users_id"] = "ID";
$strings["users_login_name"] = "サインイン名";
$strings["users_password"] = "パスワード";
$strings["Password"] = "パスワード";
$strings["FirstName"] = "お名前";
$strings["LastName"] = "性";
$strings["users_fname"] = "お名前";
$strings["users_lname"] = "性";
$strings["users_email"] = "Eメール";
$strings["Email"] = "Eメール";
$strings["EmailSystem"] = "Eメールシステム";
$strings["Nickname"] = "ニックネーム";
$strings["Cloakname"] = "クロークネーム";
$strings["ProfilePhoto"] = "プロフィールの写真";
$strings["DefaultViewableName"] = "デフォルト見える名前";
$strings["SocialNetworkViewableName"] = "ソーシャル・ネットワークのデフォルト見える名前";
$strings["FriendsViewableName"] = "友達のデフォルト見える名前";
$strings["TwitterName"] = "トィターのユーザ名";
$strings["TwitterPassword"] = "トィターのパスワード";
$strings["LinkedInName"] = "LinkedInのユーザ名";

#########################
# Actions
#########################

$strings["action_add"] = "追加";
$strings["action_add_event"] = "イベントを追加";
$strings["action_add_media"] = "コンテンツを追加";
$strings["action_events_return"] = "イベント一覧へ戻る";

$strings["action_AddNew"] = "新規を追加";
$strings["action_addNew"] = "新規を追加";
$strings["action_edit"] = "編集";
$strings["action_back"] = "←戻る";
$strings["action_first"] = "最初";
$strings["action_last"] = "最後";
$strings["action_next"] = "次";
$strings["action_previous"] = "前";
$strings["action_page"] = "ページ";
$strings["action_page_of"] = "の";
$strings["action_page_of_items"] = "アイテム";

$strings["action_addnew"] = "新規追加";
$strings["action_showall"] = "全て詳細";
$strings["action_clicktologin"] = "クリックでサインイン";
$strings["action_login"] = "サインイン";
$strings["action_login_retrieve"] = "アクセスを忘れたの方";

$strings["action_logout"] = "サインアウト";
$strings["action_create"] = "クリエート";
$strings["action_create_relationship"] = "連携を作る";
$strings["action_update"] = "更新";
$strings["action_search"] = "検索";
$strings["action_search_keyword"] = "キーワード";
$strings["action_search_via_keyword"] = "キーワードで検索";
$strings["action_select"] = "選択";
$strings["action_select_fb"] = "選択するとFacebookのアイテムに連携する";
$strings["action_select_request"] = "選んでください";
$strings["action_selectParty"] = "パーティーを選んでください";

$strings["action_copy_link_share"] = "下記のURLをコピーして友達にメールで共有しましょう;";
$strings["action_copy_code_embedd"] = "下記のコードをコピーしてどこでものページにエムベッドしましょう;";

$strings["action_send_private_message"] = "プライベートメッセージを送信";

$strings["action_change_language"] = "言語を変更";
$strings["action_make_suggestion"] = "何か提案しよう！";
$strings["action_minimiserestore"] = "ウィンドーを開く・閉じる";
$strings["action_add_bookmarks"] = "私のブックマークに追加";
$strings["action_request_ownership_transfer"] = "オーナシップのトランスファーをリクエスト";

$strings["action_click_here_to_expand"] = "ウィンドーを拡大するために、クリックしてください";
$strings["action_click_here_to_minimise"] = "ウィンドーを小さくするために、クリックしてください";
$strings["action_click_here_to_openclose"] = "ウィンドーを閉じるために、クリックしてください";
$strings["action_click_here_to_request"] = "リクエストするために、クリックしてください";
$strings["action_click_here_to_manage"] = "管理するために、クリックしてください";
$strings["action_click_here_to_clone"] = "クローンするために、クリックしてください";
$strings["action_click_here_to_learn_more"] = "より多くを学ぶために、クリックしてください";
$strings["action_click_here_to_try_again"] = "やり直すためにこちらへクリックしてください";
$strings["action_click_here_to_retrieve"] = "忘れた場合、こちらへクリックしてください";
$strings["action_click_here_to_view_full_votes"] = "完全な票統計を見るために、クリックしてください";
$strings["action_click_here_to_hide_embedded"] = "埋め込まれたサービスを隠すために、クリックしてください";
$strings["action_click_here_to_make_news"] = "新聞ダネ－ニュースになるために、クリックしてください！";

$strings["action_click_to_login"] = "クリックでサインイン";

$strings["action_close"] = "閉じる";

$strings["action_contact_owner"] = "オーナーに連絡する";
$strings["action_contact"] = "お問い合わせ";
$strings["action_contact_us"] = "お問い合わせ";
$strings["action_create_new_party"] = "新パーティーを作ろう！";

$strings["action_join_socialnetwork"] = "このソーシャルネットワークにジョインしましょう！";

$strings["action_post"] = "ポースト";

$strings["action_share_this_page"] = "このページを共有！";

$strings["action_view"] = "詳細";
$strings["action_view_here"] = "こちらへ詳細";
$strings["action_view_all"] = "全て詳細";
$strings["action_view_event"] = "イベントを詳細";

$strings["action_Vote_for"] = "投票しましょう！";
$strings["action_Vote_for_this_Government"] = "この政府に投票してください";
$strings["action_Vote_for_this_GovernmentType"] = "この政府タイプに投票してください";
$strings["action_Vote_for_this_Constitution"] = "この憲法に投票してください";
$strings["action_Vote_for_this_PoliticalParty"] = "この政治党に投票してください";
$strings["action_Vote_for_this_PoliticalPartyPolicy"] = "この政治党のポリシーに投票してください";
$strings["action_Vote_for_this_Organisation"] = "この組織に投票してください";
$strings["action_Vote_for_this_OrganisationPolicy"] = "この組織のポリシーに投票してください";

$strings["action_Nominate_for_this_Role"] = "この役割のために候補に挙げてください";

$strings["action_send_message"] = "メッセージを送信";

$strings["action_Share"] = "共有";

$strings["company_name"] = "会社名";
$strings["company_sponsor"] = "ロケーション・イベントのスポンサー";

$strings["country"] = "国";

$strings["location"] = "場所";
$strings["location_name"] = "場所名";
$strings["location_type"] = "場所のタイプ";
$strings["location_info"] = "場所の内容";
$strings["location_direction"] = "方向";
$strings["location_number"] = "場所の番号";
$strings["location_position"] = "ポジション";

$strings["event_name"] = "イベント名";
$strings["event_lineup"] = "イベント一覧";
$strings["event_date_start"] = "イベント開始の日付";
$strings["event_date_end"] = "イベント終了の日付";
$strings["event_info"] = "イベント情報";
$strings["event_map"] = "イベント地図";
$strings["event_click_message"] = "コンテンツを表示する為席番号をクリックして下さい";
$strings["event_and_locations"] = "イベントとロケーション";
$strings["event_see_more"] = "もっとイベントを選択するために、地図の下に参照ください。。";

$strings["categories"] = "カテゴリー一覧";
$strings["par_cat"] = "親カテゴリー";
$strings["sub_cat"] = "子カテゴリー";

$strings["contents"] = "コンテンツ";
$strings["contents_latest"] = "最新のコンテンツ";
$strings["content_owner"] = "オーナー";
$strings["content_selected"] = "選択したコンテンツ";

// My Account

$strings["my_account"] = "マイアカウント";

// Search

$strings["search"] = "検索";

$strings["last_year"] = "享年";
$strings["last_month"] = "先月";
$strings["yesterday"] = "昨日";
$strings["this_year"] = "今年";
$strings["this_month"] = "今月";
$strings["today"] = "今日";
$strings["clear"] = "クリア";

// View

$strings["Views"] = "表数";
$strings["view_limit"] = "表示制限";
$strings["view_current"] = "現在";

$strings["title"] = "タイトル";

// Synch Config
$strings["param"] = "パラメーター";
$strings["value"] = "バリュー";
$strings["ValueType"] = "バリュータイプ";
$strings["ValueTypes"] = "バリュータイプの一覧";
$strings["value_yes"] = "はい";
$strings["value_no"] = "いいえ";

// Products
$strings["products"] = "商品";

// Users
$strings["User"] = "ユーザー";
$strings["users"] = "ユーザー";
$strings["Users"] = "ユーザー";

// Empty Messages
$strings["Empty_Listed"] = "まだアイテムが登録されてない。。..";

// Error Messages
$strings["l_Login_Error"] = "アラ！何か正しくない。。。";
$strings["l_Login_Success"] = "サインインが成功しました！こちらへクリック。。";

$strings["SubmissionErrorEmptyItem"] = "あとに続いているアイテムは、空ではありえません：";
$strings["SubmissionErrorAlreadyExists"] = "あとに続いているアイテムが、すでに存在します： ";
$strings["SubmissionErrorWrongFormat"] = "あとに続いているアイテム・フォーマットは、正しくありません：";
$strings["SubmissionShareDefaultSubject_p1"] = "貴方に添付したアイテムを共有したいです。";
$strings["SubmissionShareDefaultSubject_p2"] = " 宜しくお願いします！ ";
$strings["SubmissionThankyou"] = "あなたの服従をありがとう！";
$strings["SubmissionSuccess"] = "あなたの服従は、成功でした！それをチェックして、必要あらばそれを編集してください。";
$strings["SubmissionRequired"] = " が必須！";

// Email Delivery Messages
$strings["EmailDeliverySubject_Registration"] = " アカウントのアクセス情報";
$strings["EmailDeliverySubject_BodyP1"] = "さん、次の情報で登録しました ";
$strings["EmailDeliverySubject_BodyP2"] = " 次のメールアドレス:";
$strings["EmailDeliverySubject_BodyP3"] = "次のパスワードを使ってアカウントをアクセスしてください：";
$strings["EmailDeliverySubject_BodyP4"] = "サービスを利用して楽しんでください ";

// Registration Messages
$strings["RegoSubject_Registration"] = " アカウントの登録";
$strings["RegoFormTitle"] = "アカウントの登録";
$strings["NeedAnAccount"] = "アカウントが必要ですか？";
$strings["RegisterHere"] = "こちらへ登録ください";
$strings["AccessProblems"] = "アクセスの問題の方";
$strings["RetrieveHere"] = "忘れた場合、こちらへ";
$strings["RegistrationSuccess"] = "おめでとうございます！アカウントの作成が成功しました。メールをご確認ください。";

$strings["RegisterAsProvider"] = "プロバイダーの登録";
$strings["RegisterAsReseller"] = "リセラーの登録";
$strings["RegisterAsClient"] = "お客様の登録";

$strings["EmailForgottenPass_P1"] = "アカウントを確認しています ";
$strings["EmailForgottenPass_P2"] = " 確証を確認しています。。。 ";

$strings["Login_Forgot"] = "あなたの電子メール・アドレスを提供しなさいので、我々はあなたのパスワードを送ることができます";
$strings["Login_ForgotProvideEmail"] = "パスワードを送るためにメールアドレスを教えてください";
$strings["LoginErrorEmail"] = "正しいメールアドレスを入力してください";
$strings["LoginErrorEmailNoAccount"] = "申し訳ございませんが、アカウントがないです。このメールアドレスはシステムに入っておりません";
$strings["LoginEmailSubmissionSuccess"] = "メールアドレスを見付けました。メールを確認してパスワードを送りました。";
$strings["LoginEmailDeliveryProblem"] = "メール送信の問題が発生しました。管理者にご確認ください：";

// Form Messages
$strings["message_kakunin"] = "フォームデータをご確認ください。正しければ確認を押してください。";
$strings["message_have_permission"] = "あなたには、アクション、エフェクト、投票、コメントとより多くを作成することが出来ます...";
$strings["message_have_no_permission"] = "アクション、エフェクト、投票、コメントとより多くを作成する為に、サインインや登録が必要です...";
$strings["message_restricted_area"] = "アクセスしようとしているページが制限されています。管理者にお問い合わせください";

$strings["message_create_Organisation_based_on"] = "You can create and base a new Organisation upon this one (or any other found in the top left list).";
//$strings["message_create_Organisation_scratch"] = "To start completely fresh, click on the Government or Government Type of your choice from the left section on the top page and create from there.";

$strings["message_request_to_join_administration"] = "You are logged in and the Administrators are accepting Requests to join the Administration.<P>
Please note that you need to provide a solid case and your identity can be verified by the current Administrators for them to seriously consider your request. Reasons why this feature is enabled is to allow responsible people to join in building - to make it as good as it can be - and as you can see from the existing Governments (Example: United States of America Government) - there are a lot of parts that need to be considered..";

$strings["message_request_to_join_administration_disabled"] = "管理者は、要請が現在この政府に参加するのを許していません。";

$strings["message_required"] = "（必須）";

$strings["message_login_to_administor"] = "あなたはサインインしてないです。あなたにはログインしなければならなくて、管理者に対する政府権利がなければならなくて、政府アクセスにこれを管理するよう求めます。";

$strings["message_not_logged-in"] = "あなたはサインインしてないです。";

$strings["message_need_to_log-in-socialnetworks"] = "このソーシャルネットワークにジョインするために先にサインインしてください。";

$strings["message_not_logged-in_cant_add"] = "あなたはサインインしてないです。アイテムを登録したり、投票したりすることができません...";

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

include ($location."lingo/lingo-content.ja.php");

#
###################

$strings["Content_Developers"] = "<center><font color=#FBB117 size=5><B>開発者 - 私たちをサポートしてください！</B></font></center>
<font size=\"3\">
<P>
ブートストラップで実行されている - 値を追加し、いくつかの肯定的な混乱を作ることを望んで我々は、世界の市民にこのサービスを持って来るために懸命に働いて、小さな会社です。純粋なビジネスの懸念として、ベンチャーキャピタリストが理解し、開かれたコミュニティとして - これはスタッフの夢が上に構築することができますです。
<P>
<B>リリース計画;</B>
<P> 
*メディアインテグレーション<BR>
*API<BR>
*動的レポート<BR>
<P>
<B>私たちはあなたの助けが必要です！</B>
<P>
*モビリティ - のiPhone＆Androidアプリ<BR>
*パートナー - これより良くより早く作るために開発するために私達に手を貸してくれ！
</font><P>";

$strings["Content_PrivacyPolicy"] = "<center><font color=#FBB117 size=5><B>個人情報保護方針</B></font></center>
<P>
<font size=\"3\">私たちは、できるだけ安全私たちのサービスをすることを目指して - あなたと私たちの情報を保護する。 </font>
<P><font size=\"3\">これを行うには、我々は暗号化された任意のセクションへのリンクを作った。次に、ページやコンテンツへのアクセスがさらに暗号化されています。</font>
<P><font size=\"3\">そうしないと、あなたの明示的願望なしで - これまで - 我々はまた、我々は第三者にあなたの個人情報を公表しないという約束をする固体。</font>
<P><font size=\"3\">すべてのコンテンツはプライバシーの状態では、デフォルトで、です。あなたが大規模で世界に何かを開きたい場合は、この設定はいつでも変更できます。</font><P>";

$strings["Content_TermsOfUse"] = "<center><font color=#FBB117 size=5><B>利用規約</B></font></center>
<P><font size=\"3\">本サイトおよびサービスにアクセスすることにより、あなたは利用規約に同意するものとします。</font>
<P><font size=\"3\">ユニークな - 我々は、それが有用な貴重な、そして最も重要なこと、このサービスの開発にかなりの努力を入れている！</font>
<P><font size=\"3\">我々は、特にどこかに何かを見た後に、技術革新はしばしばアイデアによって駆動されていることを理解し、我々のサービスを見た後、人々は技術革新の火花を得ると確信しています。私たちが求めるのは、あなたが我々がやっているものをコピーしないことです。そうするためには、基本的にとにかくサービスの利用規約に反する - と本当にあなたのように退屈だろう。</font>
<P><font size=\"3\">我々は、いくつかの値を追加すると同時に、公正使用の期待を持っていない期待してパブリックドメインにこのサービスを入れた。</font>
<P><font size=\"3\">皆様のご理解に感謝し、あなたが私たちのサービスを利用して楽しむことを願っています。
</font><P>";
?>