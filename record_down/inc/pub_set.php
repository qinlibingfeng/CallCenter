<?php 
$SQLdate = date("Y-m-d H:i:s");

$PHP_AUTH_USER=$_SERVER['PHP_AUTH_USER'];
$PHP_AUTH_PW=$_SERVER['PHP_AUTH_PW'];
$PHP_SELF=$_SERVER['PHP_SELF'];

$local_DEF = 'Local/';
$conf_silent_prefix = '7';
$local_AMP = '@';
$ext_context = 'demo';
$recording_exten = '8309';
$WeBRooTWritablE = '1';
$non_latin = '1';	# set to 1 for UTF rules
$AM_shift_BEGIN = '03:45:00';
$AM_shift_END = '17:45:00';
$PM_shift_BEGIN = '17:45:01';
$PM_shift_END = '23:59:59';
$admin_qc_enabled = '0';


$lead_id=trim($_REQUEST["lead_id"]);

$called_since_last_reset=trim($_REQUEST["called_since_last_reset"]);
 
$active=trim($_REQUEST["active"]);
$list_active=trim($_REQUEST["list_active"]);

$user_id=trim($_REQUEST["user_id"]);

$campaign_active=trim($_REQUEST["campaign_active"]);
$dial_statuses=$_REQUEST["dial_statuses"];
$campaign_script=trim($_REQUEST["campaign_script"]);

$adaptive_dl_diff_target=trim($_REQUEST["adaptive_dl_diff_target"]);
$adaptive_dropped_percentage=trim($_REQUEST["adaptive_dropped_percentage"]);
$adaptive_intensity=trim($_REQUEST["adaptive_intensity"]);
$adaptive_latest_server_time=trim($_REQUEST["adaptive_latest_server_time"]);
$adaptive_maximum_level=trim($_REQUEST["adaptive_maximum_level"]);
$SUB=trim($_REQUEST["SUB"]);
$ADD=trim($_REQUEST["ADD"]);
$admin_hangup_enabled=trim($_REQUEST["admin_hangup_enabled"]);
$admin_hijack_enabled=trim($_REQUEST["admin_hijack_enabled"]);
$admin_monitor_enabled=trim($_REQUEST["admin_monitor_enabled"]);
$AFLogging_enabled=trim($_REQUEST["AFLogging_enabled"]);
$agent_choose_ingroups=trim($_REQUEST["agent_choose_ingroups"]);
$agentcall_manual=trim($_REQUEST["agentcall_manual"]);
$agentonly_callbacks=trim($_REQUEST["agentonly_callbacks"]);
$AGI_call_logging_enabled=trim($_REQUEST["AGI_call_logging_enabled"]);
$agi_output=trim($_REQUEST["agi_output"]);
$allcalls_delay=trim($_REQUEST["allcalls_delay"]);
$allow_closers=trim($_REQUEST["allow_closers"]);
$alt_number_dialing=trim($_REQUEST["alt_number_dialing"]);
$alter_agent_interface_options=trim($_REQUEST["alter_agent_interface_options"]);
$am_message_exten=trim($_REQUEST["am_message_exten"]);
$amd_send_to_vmx=trim($_REQUEST["amd_send_to_vmx"]);
$answer_transfer_agent=trim($_REQUEST["answer_transfer_agent"]);
$ast_admin_access=trim($_REQUEST["ast_admin_access"]);
$ast_delete_phones=trim($_REQUEST["ast_delete_phones"]);
$asterisk_version=trim($_REQUEST["asterisk_version"]);
$ASTmgrSECRET=trim($_REQUEST["ASTmgrSECRET"]);
$ASTmgrUSERNAME=trim($_REQUEST["ASTmgrUSERNAME"]);
$ASTmgrUSERNAMElisten=trim($_REQUEST["ASTmgrUSERNAMElisten"]);
$ASTmgrUSERNAMEsend=trim($_REQUEST["ASTmgrUSERNAMEsend"]);
$ASTmgrUSERNAMEupdate=trim($_REQUEST["ASTmgrUSERNAMEupdate"]);
$attempt_delay=trim($_REQUEST["attempt_delay"]);
$attempt_maximum=trim($_REQUEST["attempt_maximum"]);
$auto_dial_level=trim($_REQUEST["auto_dial_level"]);
$auto_dial_next_number=trim($_REQUEST["auto_dial_next_number"]);
$available_only_ratio_tally=trim($_REQUEST["available_only_ratio_tally"]);
$call_out_number_group=trim($_REQUEST["call_out_number_group"]);
$call_parking_enabled=trim($_REQUEST["call_parking_enabled"]);
$call_time_comments=trim($_REQUEST["call_time_comments"]);
$call_time_id=trim($_REQUEST["call_time_id"]);
$call_time_name=trim($_REQUEST["call_time_name"]);
$CallerID_popup_enabled=trim($_REQUEST["CallerID_popup_enabled"]);
$campaign_cid=trim($_REQUEST["campaign_cid"]);
$campaign_detail=trim($_REQUEST["campaign_detail"]);
$campaign_id=trim($_REQUEST["campaign_id"]);
$campaign_name=trim($_REQUEST["campaign_name"]);
$campaign_rec_exten=trim($_REQUEST["campaign_rec_exten"]);
$campaign_rec_filename=trim($_REQUEST["campaign_rec_filename"]);
$ingroup_rec_filename=trim($_REQUEST["ingroup_rec_filename"]);
$campaign_recording=trim($_REQUEST["campaign_recording"]);
$campaign_vdad_exten=trim($_REQUEST["campaign_vdad_exten"]);
$change_agent_campaign=trim($_REQUEST["change_agent_campaign"]);
$client_browser=trim($_REQUEST["client_browser"]);
$closer_default_blended=trim($_REQUEST["closer_default_blended"]);
$company=trim($_REQUEST["company"]);
$computer_ip=trim($_REQUEST["computer_ip"]);
$conf_exten=trim($_REQUEST["conf_exten"]);
$conf_on_extension=trim($_REQUEST["conf_on_extension"]);
$conferencing_enabled=trim($_REQUEST["conferencing_enabled"]);
$CoNfIrM=trim($_REQUEST["CoNfIrM"]);
$ct_default_start=trim($_REQUEST["ct_default_start"]);
$ct_default_stop=trim($_REQUEST["ct_default_stop"]);
$ct_friday_start=trim($_REQUEST["ct_friday_start"]);
$ct_friday_stop=trim($_REQUEST["ct_friday_stop"]);
$ct_monday_start=trim($_REQUEST["ct_monday_start"]);
$ct_monday_stop=trim($_REQUEST["ct_monday_stop"]);
$ct_saturday_start=trim($_REQUEST["ct_saturday_start"]);
$ct_saturday_stop=trim($_REQUEST["ct_saturday_stop"]);
$ct_sunday_start=trim($_REQUEST["ct_sunday_start"]);
$ct_sunday_stop=trim($_REQUEST["ct_sunday_stop"]);
$ct_thursday_start=trim($_REQUEST["ct_thursday_start"]);
$ct_thursday_stop=trim($_REQUEST["ct_thursday_stop"]);
$ct_tuesday_start=trim($_REQUEST["ct_tuesday_start"]);
$ct_tuesday_stop=trim($_REQUEST["ct_tuesday_stop"]);
$ct_wednesday_start=trim($_REQUEST["ct_wednesday_start"]);
$ct_wednesday_stop=trim($_REQUEST["ct_wednesday_stop"]);
$DBX_database=trim($_REQUEST["DBX_database"]);
$DBX_pass=trim($_REQUEST["DBX_pass"]);
$DBX_port=trim($_REQUEST["DBX_port"]);
$DBX_server=trim($_REQUEST["DBX_server"]);
$DBX_user=trim($_REQUEST["DBX_user"]);
$DBY_database=trim($_REQUEST["DBY_database"]);
$DBY_pass=trim($_REQUEST["DBY_pass"]);
$DBY_port=trim($_REQUEST["DBY_port"]);
$DBY_server=trim($_REQUEST["DBY_server"]);
$DBY_user=trim($_REQUEST["DBY_user"]);
$delete_call_times=trim($_REQUEST["delete_call_times"]);
$delete_campaigns=trim($_REQUEST["delete_campaigns"]);
$delete_filters=trim($_REQUEST["delete_filters"]);
$delete_ingroups=trim($_REQUEST["delete_ingroups"]);
$delete_lists=trim($_REQUEST["delete_lists"]);
$delete_remote_agents=trim($_REQUEST["delete_remote_agents"]);
$delete_scripts=trim($_REQUEST["delete_scripts"]);
$delete_user_groups=trim($_REQUEST["delete_user_groups"]);
$delete_users=trim($_REQUEST["delete_users"]);
$dial_method=trim($_REQUEST["dial_method"]);
$dial_prefix=trim($_REQUEST["dial_prefix"]);
$dial_status_a=trim($_REQUEST["dial_status_a"]);
$dial_status_b=trim($_REQUEST["dial_status_b"]);
$dial_status_c=trim($_REQUEST["dial_status_c"]);
$dial_status_d=trim($_REQUEST["dial_status_d"]);
$dial_status_e=trim($_REQUEST["dial_status_e"]);
$dial_timeout=trim($_REQUEST["dial_timeout"]);
$dialplan_number=trim($_REQUEST["dialplan_number"]);
$drop_call_seconds=trim($_REQUEST["drop_call_seconds"]);
$drop_exten=trim($_REQUEST["drop_exten"]);
$drop_action=trim($_REQUEST["drop_action"]);
$dtmf_send_extension=trim($_REQUEST["dtmf_send_extension"]);
$enable_fast_refresh=trim($_REQUEST["enable_fast_refresh"]);
$enable_persistant_mysql=trim($_REQUEST["enable_persistant_mysql"]);
$ext_context=trim($_REQUEST["ext_context"]);
//$extension=trim($_REQUEST["extension"]);
$fast_refresh_rate=trim($_REQUEST["fast_refresh_rate"]);
$force_logout=trim($_REQUEST["force_logout"]);
$fronter_display=trim($_REQUEST["fronter_display"]);
$full_name=trim($_REQUEST["full_name"]);
//$fullname=trim($_REQUEST["fullname"]);
$get_call_launch=trim($_REQUEST["get_call_launch"]);
$group_color=trim($_REQUEST["group_color"]);
$group_id=trim($_REQUEST["group_id"]);
$group_name=trim($_REQUEST["group_name"]);
$groups=trim($_REQUEST["groups"]);
$XFERgroups=trim($_REQUEST["XFERgroups"]);
$HKstatus=trim($_REQUEST["HKstatus"]);
$hopper_level=trim($_REQUEST["hopper_level"]);
$hotkey=trim($_REQUEST["hotkey"]);
$hotkeys_active=trim($_REQUEST["hotkeys_active"]);
$install_directory=trim($_REQUEST["install_directory"]);
$lead_filter_comments=trim($_REQUEST["lead_filter_comments"]);
$lead_filter_id=trim($_REQUEST["lead_filter_id"]);
$lead_filter_name=trim($_REQUEST["lead_filter_name"]);
$lead_filter_sql=trim($_REQUEST["lead_filter_sql"]);
$lead_filter_field=trim($_REQUEST["lead_filter_field"]);
$lead_order=trim($_REQUEST["lead_order"]);
$list_id=trim($_REQUEST["list_id"]);
$list_name=trim($_REQUEST["list_name"]);
$load_leads=trim($_REQUEST["load_leads"]);
$local_call_time=trim($_REQUEST["local_call_time"]);
$local_gmt=trim($_REQUEST["local_gmt"]);
$local_web_callerID_URL=trim($_REQUEST["local_web_callerID_URL"]);
$login=trim($_REQUEST["login"]);
$login_campaign=trim($_REQUEST["login_campaign"]);
$login_pass=trim($_REQUEST["login_pass"]);
$login_user=trim($_REQUEST["login_user"]);
$max_vicidial_trunks=trim($_REQUEST["max_vicidial_trunks"]);
$modify_call_times=trim($_REQUEST["modify_call_times"]);
$modify_leads=trim($_REQUEST["modify_leads"]);
$monitor_prefix=trim($_REQUEST["monitor_prefix"]);
$next_agent_call=trim($_REQUEST["next_agent_call"]);
$number_of_lines=trim($_REQUEST["number_of_lines"]);
$old_campaign_id=trim($_REQUEST["old_campaign_id"]);
$old_conf_exten=trim($_REQUEST["old_conf_exten"]);
$old_extension=trim($_REQUEST["old_extension"]);
$old_server_id=trim($_REQUEST["old_server_id"]);
$old_server_ip=trim($_REQUEST["old_server_ip"]);
$OLDuser_group=trim($_REQUEST["OLDuser_group"]);
$omit_phone_code=trim($_REQUEST["omit_phone_code"]);
$outbound_cid=trim($_REQUEST["outbound_cid"]);
$park_ext=trim($_REQUEST["park_ext"]);
$park_file_name=trim($_REQUEST["park_file_name"]);
$park_on_extension=trim($_REQUEST["park_on_extension"]);
$pass=trim($_REQUEST["pass"]);
$phone_ip=trim($_REQUEST["phone_ip"]);
$phone_login=trim($_REQUEST["phone_login"]);
$phone_number=trim($_REQUEST["phone_number"]);
$phone_pass=trim($_REQUEST["phone_pass"]);
$phone_type=trim($_REQUEST["phone_type"]);
$picture=trim($_REQUEST["picture"]);
$protocol=trim($_REQUEST["protocol"]);
$QUEUE_ACTION_enabled=trim($_REQUEST["QUEUE_ACTION_enabled"]);
$recording_exten=trim($_REQUEST["recording_exten"]);
$remote_agent_id=trim($_REQUEST["remote_agent_id"]);
$reset_hopper=trim($_REQUEST["reset_hopper"]);
$reset_list=trim($_REQUEST["reset_list"]);
$safe_harbor_exten=trim($_REQUEST["safe_harbor_exten"]);
$drop_action=trim($_REQUEST["drop_action"]);
$scheduled_callbacks=trim($_REQUEST["scheduled_callbacks"]);
$script_comments=trim($_REQUEST["script_comments"]);
$script_id=trim($_REQUEST["script_id"]);
$script_name=trim($_REQUEST["script_name"]);
$script_text=trim($_REQUEST["script_text"]);
$selectable=trim($_REQUEST["selectable"]);
$server_description=trim($_REQUEST["server_description"]);
$server_id=trim($_REQUEST["server_id"]);
$server_ip=trim($_REQUEST["server_ip"]);
$stage=trim($_REQUEST["stage"]);
$state_call_time_state=trim($_REQUEST["state_call_time_state"]);
$state_rule=trim($_REQUEST["state_rule"]);
$status=trim($_REQUEST["status"]);
$status_id=trim($_REQUEST["status_id"]);
$status_name=trim($_REQUEST["status_name"]);
$submit=trim($_REQUEST["submit"]);
$SUBMIT=trim($_REQUEST["SUBMIT"]);
$sys_perf_log=trim($_REQUEST["sys_perf_log"]);
$telnet_host=trim($_REQUEST["telnet_host"]);
$telnet_port=trim($_REQUEST["telnet_port"]);
$updater_check_enabled=trim($_REQUEST["updater_check_enabled"]);
$use_internal_dnc=trim($_REQUEST["use_internal_dnc"]);
$use_campaign_dnc=trim($_REQUEST["use_campaign_dnc"]);
$user=trim($_REQUEST["user"]);
$user_group=trim($_REQUEST["user_group"]);
$user_level=trim($_REQUEST["user_level"]);
$user_start=trim($_REQUEST["user_start"]);
$user_switching_enabled=trim($_REQUEST["user_switching_enabled"]);
$vd_server_logs=trim($_REQUEST["vd_server_logs"]);
$VDstop_rec_after_each_call=trim($_REQUEST["VDstop_rec_after_each_call"]);
$VICIDIAL_park_on_extension=trim($_REQUEST["VICIDIAL_park_on_extension"]);
$VICIDIAL_park_on_filename=trim($_REQUEST["VICIDIAL_park_on_filename"]);
$vicidial_recording=trim($_REQUEST["vicidial_recording"]);
$vicidial_transfers=trim($_REQUEST["vicidial_transfers"]);
$VICIDIAL_web_URL=trim($_REQUEST["VICIDIAL_web_URL"]);
$voicemail_button_enabled=trim($_REQUEST["voicemail_button_enabled"]);
$voicemail_dump_exten=trim($_REQUEST["voicemail_dump_exten"]);
$voicemail_ext=trim($_REQUEST["voicemail_ext"]);
$voicemail_exten=trim($_REQUEST["voicemail_exten"]);
$voicemail_id=trim($_REQUEST["voicemail_id"]);
$web_form_address=trim($_REQUEST["web_form_address"]);
$wrapup_message=trim($_REQUEST["wrapup_message"]);
$wrapup_seconds=trim($_REQUEST["wrapup_seconds"]);
$xferconf_a_dtmf=trim($_REQUEST["xferconf_a_dtmf"]);
$xferconf_a_number=trim($_REQUEST["xferconf_a_number"]);
$xferconf_b_dtmf=trim($_REQUEST["xferconf_b_dtmf"]);
$xferconf_b_number=trim($_REQUEST["xferconf_b_number"]);
$vicidial_balance_active=trim($_REQUEST["vicidial_balance_active"]);
$balance_trunks_offlimits=trim($_REQUEST["balance_trunks_offlimits"]);
$dedicated_trunks=trim($_REQUEST["dedicated_trunks"]);
$trunk_restriction=trim($_REQUEST["trunk_restriction"]);
$campaigns=trim($_REQUEST["campaigns"]);
$dial_level_override=trim($_REQUEST["dial_level_override"]);
$concurrent_transfers=trim($_REQUEST["concurrent_transfers"]);
$auto_alt_dial=trim($_REQUEST["auto_alt_dial"]);
$modify_users=trim($_REQUEST["modify_users"]);
$modify_campaigns=trim($_REQUEST["modify_campaigns"]);
$modify_lists=trim($_REQUEST["modify_lists"]);
$modify_scripts=trim($_REQUEST["modify_scripts"]);
$modify_filters=trim($_REQUEST["modify_filters"]);
$modify_ingroups=trim($_REQUEST["modify_ingroups"]);
$modify_usergroups=trim($_REQUEST["modify_usergroups"]);
$modify_remoteagents=trim($_REQUEST["modify_remoteagents"]);
$modify_servers=trim($_REQUEST["modify_servers"]);
$view_reports=trim($_REQUEST["view_reports"]);
$agent_pause_codes_active=trim($_REQUEST["agent_pause_codes_active"]);
$pause_code=trim($_REQUEST["pause_code"]);
$pause_code_name=trim($_REQUEST["pause_code_name"]);
$billable=trim($_REQUEST["billable"]);
$campaign_description=trim($_REQUEST["campaign_description"]);
$campaign_stats_refresh=trim($_REQUEST["campaign_stats_refresh"]);
$list_description=trim($_REQUEST["list_description"]);
$vicidial_recording_override=trim($_REQUEST["vicidial_recording_override"]);
$use_non_latin=trim($_REQUEST["use_non_latin"]);
$webroot_writable=trim($_REQUEST["webroot_writable"]);
$enable_queuemetrics_logging=trim($_REQUEST["enable_queuemetrics_logging"]);
$queuemetrics_server_ip=trim($_REQUEST["queuemetrics_server_ip"]);
$queuemetrics_dbname=trim($_REQUEST["queuemetrics_dbname"]);
$queuemetrics_login=trim($_REQUEST["queuemetrics_login"]);
$queuemetrics_pass=trim($_REQUEST["queuemetrics_pass"]);
$queuemetrics_url=trim($_REQUEST["queuemetrics_url"]);
$queuemetrics_log_id=trim($_REQUEST["queuemetrics_log_id"]);
$dial_status=trim($_REQUEST["dial_status"]);
$queuemetrics_eq_prepend=trim($_REQUEST["queuemetrics_eq_prepend"]);
$vicidial_agent_disable=trim($_REQUEST["vicidial_agent_disable"]);
$disable_alter_custdata=trim($_REQUEST["disable_alter_custdata"]);
$alter_custdata_override=trim($_REQUEST["alter_custdata_override"]);
$no_hopper_leads_logins=trim($_REQUEST["no_hopper_leads_logins"]);
$enable_sipsak_messages=trim($_REQUEST["enable_sipsak_messages"]);
$allow_sipsak_messages=trim($_REQUEST["allow_sipsak_messages"]);
$admin_home_url=trim($_REQUEST["admin_home_url"]);
$list_order_mix=trim($_REQUEST["list_order_mix"]);
$vcl_id=trim($_REQUEST["vcl_id"]);
$vcl_name=trim($_REQUEST["vcl_name"]);
$list_mix_container=trim($_REQUEST["list_mix_container"]);
$mix_method=trim($_REQUEST["mix_method"]);
$human_answered=trim($_REQUEST["human_answered"]);
$category=trim($_REQUEST["category"]);
$vsc_id=trim($_REQUEST["vsc_id"]);
$vsc_name=trim($_REQUEST["vsc_name"]);
$vsc_description=trim($_REQUEST["vsc_description"]);
$tovdad_display=trim($_REQUEST["tovdad_display"]);
$mix_container_item=trim($_REQUEST["mix_container_item"]);
$enable_agc_xfer_log=trim($_REQUEST["enable_agc_xfer_log"]);
$after_hours_action=trim($_REQUEST["after_hours_action"]);
$after_hours_message_filename=trim($_REQUEST["after_hours_message_filename"]);
$after_hours_exten=trim($_REQUEST["after_hours_exten"]);
$after_hours_voicemail=trim($_REQUEST["after_hours_voicemail"]);
$welcome_message_filename=trim($_REQUEST["welcome_message_filename"]);
$moh_context=trim($_REQUEST["moh_context"]);
$onhold_prompt_filename=trim($_REQUEST["onhold_prompt_filename"]);
$prompt_interval=trim($_REQUEST["prompt_interval"]);
$agent_alert_exten=trim($_REQUEST["agent_alert_exten"]);
$agent_alert_delay=trim($_REQUEST["agent_alert_delay"]);
$group_rank=trim($_REQUEST["group_rank"]);
$campaign_allow_inbound=trim($_REQUEST["campaign_allow_inbound"]);
$manual_dial_list_id=trim($_REQUEST["manual_dial_list_id"]);
$campaign_rank=trim($_REQUEST["campaign_rank"]);
$source_campaign_id=trim($_REQUEST["source_campaign_id"]);
$source_user_id=trim($_REQUEST["source_user_id"]);
$source_group_id=trim($_REQUEST["source_group_id"]);
$default_xfer_group=trim($_REQUEST["default_xfer_group"]);
$qc_enabled=trim($_REQUEST["qc_enabled"]);
$qc_user_level=trim($_REQUEST["qc_user_level"]);
$qc_pass=trim($_REQUEST["qc_pass"]);
$qc_finish=trim($_REQUEST["qc_finish"]);
$qc_commit=trim($_REQUEST["qc_commit"]);
$qc_campaigns=trim($_REQUEST["qc_campaigns"]);
$qc_groups=trim($_REQUEST["qc_groups"]);
$queue_priority=trim($_REQUEST["queue_priority"]);
$drop_inbound_group=trim($_REQUEST["drop_inbound_group"]);
$qc_statuses=trim($_REQUEST["qc_statuses"]);
$qc_lists=trim($_REQUEST["qc_lists"]);
$qc_get_record_launch=trim($_REQUEST["qc_get_record_launch"]);
$qc_show_recording=trim($_REQUEST["qc_show_recording"]);
$qc_shift_id=trim($_REQUEST["qc_shift_id"]);
$qc_web_form_address=trim($_REQUEST["qc_web_form_address"]);
$qc_script=trim($_REQUEST["qc_script"]);
$ingroup_recording_override=trim($_REQUEST["ingroup_recording_override"]);
$code=trim($_REQUEST["code"]);
$code_name=trim($_REQUEST["code_name"]);
$afterhours_xfer_group=trim($_REQUEST["afterhours_xfer_group"]);
$alias_id=trim($_REQUEST["alias_id"]);
$alias_name=trim($_REQUEST["alias_name"]);
$logins_list=trim($_REQUEST["logins_list"]);
$shift_id=trim($_REQUEST["shift_id"]);
$shift_name=trim($_REQUEST["shift_name"]);
$shift_start_time=trim($_REQUEST["shift_start_time"]);
$shift_length=trim($_REQUEST["shift_length"]);
$shift_weekdays=trim($_REQUEST["shift_weekdays"]);
$group_shifts=rtrim($_REQUEST["group_shifts"]);
$timeclock_end_of_day=trim($_REQUEST["timeclock_end_of_day"]);
$survey_first_audio_file=trim($_REQUEST["survey_first_audio_file"]);
$survey_dtmf_digits=trim($_REQUEST["survey_dtmf_digits"]);
$survey_ni_digit=trim($_REQUEST["survey_ni_digit"]);
$survey_opt_in_audio_file=trim($_REQUEST["survey_opt_in_audio_file"]);
$survey_ni_audio_file=trim($_REQUEST["survey_ni_audio_file"]);
$survey_method=trim($_REQUEST["survey_method"]);
$survey_no_response_action=trim($_REQUEST["survey_no_response_action"]);
$survey_ni_status=trim($_REQUEST["survey_ni_status"]);
$survey_response_digit_map=trim($_REQUEST["survey_response_digit_map"]);
$survey_xfer_exten=trim($_REQUEST["survey_xfer_exten"]);
$survey_camp_record_dir=trim($_REQUEST["survey_camp_record_dir"]);
$add_timeclock_log=trim($_REQUEST["add_timeclock_log"]);
$modify_timeclock_log=trim($_REQUEST["modify_timeclock_log"]);
$delete_timeclock_log=trim($_REQUEST["delete_timeclock_log"]);
$phone_numbers=trim($_REQUEST["phone_numbers"]);
$vdc_header_date_format=trim($_REQUEST["vdc_header_date_format"]);
$vdc_customer_date_format=trim($_REQUEST["vdc_customer_date_format"]);
$vdc_header_phone_format=trim($_REQUEST["vdc_header_phone_format"]);
$disable_alter_custphone=trim($_REQUEST["disable_alter_custphone"]);
$alter_custphone_override=trim($_REQUEST["alter_custphone_override"]);
$vdc_agent_api_access=trim($_REQUEST["vdc_agent_api_access"]);
$vdc_agent_api_active=trim($_REQUEST["vdc_agent_api_active"]);
$display_queue_count=trim($_REQUEST["display_queue_count"]);
$sale_category=trim($_REQUEST["sale_category"]);
$dead_lead_category=trim($_REQUEST["dead_lead_category"]);
$manual_dial_filter=trim($_REQUEST["manual_dial_filter"]);
$agent_clipboard_copy=trim($_REQUEST["agent_clipboard_copy"]);
$agent_extended_alt_dial=trim($_REQUEST["agent_extended_alt_dial"]);
$play_place_in_line=trim($_REQUEST["play_place_in_line"]);
$play_estimate_hold_time=trim($_REQUEST["play_estimate_hold_time"]);
$hold_time_option=trim($_REQUEST["hold_time_option"]);
$hold_time_option_seconds=trim($_REQUEST["hold_time_option_seconds"]);
$hold_time_option_exten=trim($_REQUEST["hold_time_option_exten"]);
$hold_time_option_voicemail=trim($_REQUEST["hold_time_option_voicemail"]);
$hold_time_option_xfer_group=trim($_REQUEST["hold_time_option_xfer_group"]);
$hold_time_option_callback_filename=trim($_REQUEST["hold_time_option_callback_filename"]);
$hold_time_option_callback_list_id=trim($_REQUEST["hold_time_option_callback_list_id"]);
$hold_recall_xfer_group=trim($_REQUEST["hold_recall_xfer_group"]);
$no_delay_call_route=trim($_REQUEST["no_delay_call_route"]);
$play_welcome_message=trim($_REQUEST["play_welcome_message"]);
$did_id=trim($_REQUEST["did_id"]);
$source_did=trim($_REQUEST["source_did"]);
$did_pattern=trim($_REQUEST["did_pattern"]);
$did_description=trim($_REQUEST["did_description"]);
$did_active=trim($_REQUEST["did_active"]);
$did_route=trim($_REQUEST["did_route"]);
$exten_context=trim($_REQUEST["exten_context"]);
$phone=trim($_REQUEST["phone"]);
$user_unavailable_action=trim($_REQUEST["user_unavailable_action"]);
$user_route_settings_ingroup=trim($_REQUEST["user_route_settings_ingroup"]);
$call_handle_method=trim($_REQUEST["call_handle_method"]);
$agent_search_method=trim($_REQUEST["agent_search_method"]);
$phone_code=trim($_REQUEST["phone_code"]);
$email=trim($_REQUEST["email"]);
$modify_inbound_dids=trim($_REQUEST["modify_inbound_dids"]);
$delete_inbound_dids=trim($_REQUEST["delete_inbound_dids"]);
$three_way_call_cid=trim($_REQUEST["three_way_call_cid"]);
$three_way_dial_prefix=trim($_REQUEST["three_way_dial_prefix"]);
$forced_timeclock_login=trim($_REQUEST["forced_timeclock_login"]);
$answer_sec_pct_rt_stat_one=trim($_REQUEST["answer_sec_pct_rt_stat_one"]);
$answer_sec_pct_rt_stat_two=trim($_REQUEST["answer_sec_pct_rt_stat_two"]);
$list_active_change=trim($_REQUEST["list_active_change"]);
$web_form_target=trim($_REQUEST["web_form_target"]);
$alt_server_ip=trim($_REQUEST["alt_server_ip"]);
$recording_web_link=trim($_REQUEST["recording_web_link"]);
$enable_vtiger_integration=trim($_REQUEST["enable_vtiger_integration"]);
$vtiger_server_ip=trim($_REQUEST["vtiger_server_ip"]);
$vtiger_dbname=trim($_REQUEST["vtiger_dbname"]);
$vtiger_login=trim($_REQUEST["vtiger_login"]);
$vtiger_pass=trim($_REQUEST["vtiger_pass"]);
$vtiger_url=trim($_REQUEST["vtiger_url"]);
$vtiger_search_category=trim($_REQUEST["vtiger_search_category"]);
$vtiger_create_call_record=trim($_REQUEST["vtiger_create_call_record"]);
$vtiger_create_lead_record=trim($_REQUEST["vtiger_create_lead_record"]);
$vtiger_screen_login=trim($_REQUEST["vtiger_screen_login"]);
$qc_features_active=trim($_REQUEST["qc_features_active"]);
$outbound_autodial_active=trim($_REQUEST["outbound_autodial_active"]);
$cpd_amd_action=trim($_REQUEST["cpd_amd_action"]);
$download_lists=trim($_REQUEST["download_lists"]);
$active_asterisk_server=trim($_REQUEST["active_asterisk_server"]);
$generate_vicidial_conf=trim($_REQUEST["generate_vicidial_conf"]);
$rebuild_conf_files=trim($_REQUEST["rebuild_conf_files"]);
$template_id=trim($_REQUEST["template_id"]);
$conf_override=trim($_REQUEST["conf_override"]);
$template_name=trim($_REQUEST["template_name"]);
$template_contents=trim($_REQUEST["template_contents"]);
$carrier_id=trim($_REQUEST["carrier_id"]);
$carrier_name=trim($_REQUEST["carrier_name"]);
$registration_string=trim($_REQUEST["registration_string"]);
$account_entry=trim($_REQUEST["account_entry"]);
$globals_string=trim($_REQUEST["globals_string"]);
$dialplan_entry=trim($_REQUEST["dialplan_entry"]);
$group_alias_id=trim($_REQUEST["group_alias_id"]);
$group_alias_name=trim($_REQUEST["group_alias_name"]);
$caller_id_number=trim($_REQUEST["caller_id_number"]);
$caller_id_name=trim($_REQUEST["caller_id_name"]);
$agent_allow_group_alias=trim($_REQUEST["agent_allow_group_alias"]);
$default_group_alias=trim($_REQUEST["default_group_alias"]);
$outbound_calls_per_second=trim($_REQUEST["outbound_calls_per_second"]);
$shift_enforcement=trim($_REQUEST["shift_enforcement"]);
$agent_shift_enforcement_override=trim($_REQUEST["agent_shift_enforcement_override"]);
$manager_shift_enforcement_override=trim($_REQUEST["manager_shift_enforcement_override"]);
$export_reports=trim($_REQUEST["export_reports"]);
$delete_from_dnc=trim($_REQUEST["delete_from_dnc"]);
$vtiger_search_dead=trim($_REQUEST["vtiger_search_dead"]);
$vtiger_status_call=trim($_REQUEST["vtiger_status_call"]);
$sale=trim($_REQUEST["sale"]);
$dnc=trim($_REQUEST["dnc"]);
$customer_contact=trim($_REQUEST["customer_contact"]);
$not_interested=trim($_REQUEST["not_interested"]);
$unworkable=trim($_REQUEST["unworkable"]);
$user_code=trim($_REQUEST["user_code"]);
$territory=trim($_REQUEST["territory"]);
$survey_third_digit=trim($_REQUEST["survey_third_digit"]);
$survey_fourth_digit=trim($_REQUEST["survey_fourth_digit"]);
$survey_third_audio_file=trim($_REQUEST["survey_third_audio_file"]);
$survey_fourth_audio_file=trim($_REQUEST["survey_fourth_audio_file"]);
$survey_third_status=trim($_REQUEST["survey_third_status"]);
$survey_fourth_status=trim($_REQUEST["survey_fourth_status"]);
$survey_third_exten=trim($_REQUEST["survey_third_exten"]);
$survey_fourth_exten=trim($_REQUEST["survey_fourth_exten"]);
$menu_id=trim($_REQUEST["menu_id"]);
$menu_name=trim($_REQUEST["menu_name"]);
$menu_prompt=trim($_REQUEST["menu_prompt"]);
$menu_timeout=trim($_REQUEST["menu_timeout"]);
$menu_timeout_prompt=trim($_REQUEST["menu_timeout_prompt"]);
$menu_invalid_prompt=trim($_REQUEST["menu_invalid_prompt"]);
$menu_repeat=trim($_REQUEST["menu_repeat"]);
$menu_time_check=trim($_REQUEST["menu_time_check"]);
$track_in_vdac=trim($_REQUEST["track_in_vdac"]);
$source_menu=trim($_REQUEST["source_menu"]);
$agentonly_callback_campaign_lock=trim($_REQUEST["agentonly_callback_campaign_lock"]);
$sounds_central_control_active=trim($_REQUEST["sounds_central_control_active"]);
$sounds_web_server=trim($_REQUEST["sounds_web_server"]);
$sounds_web_directory=trim($_REQUEST["sounds_web_directory"]);
$sounds_update=trim($_REQUEST["sounds_update"]);
$active_voicemail_server=trim($_REQUEST["active_voicemail_server"]);
$auto_dial_limit=trim($_REQUEST["auto_dial_limit"]);
$user_territories_active=trim($_REQUEST["user_territories_active"]);
$vicidial_recording_limit=trim($_REQUEST["vicidial_recording_limit"]);
$phone_context=trim($_REQUEST["phone_context"]);
$carrier_logging_active=trim($_REQUEST["carrier_logging_active"]);
$drop_lockout_time=trim($_REQUEST["drop_lockout_time"]);
$allow_custom_dialplan=trim($_REQUEST["allow_custom_dialplan"]);
$custom_dialplan_entry=trim($_REQUEST["custom_dialplan_entry"]);
$phone_ring_timeout=trim($_REQUEST["phone_ring_timeout"]);
$conf_secret=trim($_REQUEST["conf_secret"]);
$tracking_group=trim($_REQUEST["tracking_group"]);
$no_agent_no_queue=trim($_REQUEST["no_agent_no_queue"]);
$no_agent_action=trim($_REQUEST["no_agent_action"]);
$no_agent_action_value=trim($_REQUEST["no_agent_action_value"]);
$quick_transfer_button=trim($_REQUEST["quick_transfer_button"]);
$prepopulate_transfer_preset=trim($_REQUEST["prepopulate_transfer_preset"]);
$enable_tts_integration=trim($_REQUEST["enable_tts_integration"]);
$tts_id=trim($_REQUEST["tts_id"]);
$tts_name=trim($_REQUEST["tts_name"]);
$tts_text=trim($_REQUEST["tts_text"]);
$drop_rate_group=trim($_REQUEST["drop_rate_group"]);
$agent_status_viewable_groups=trim($_REQUEST["agent_status_viewable_groups"]);
$agent_status_view_time=trim($_REQUEST["agent_status_view_time"]);
$view_calls_in_queue=trim($_REQUEST["view_calls_in_queue"]);
$view_calls_in_queue_launch=trim($_REQUEST["view_calls_in_queue_launch"]);
$grab_calls_in_queue=trim($_REQUEST["grab_calls_in_queue"]);
$call_requeue_button=trim($_REQUEST["call_requeue_button"]);
$pause_after_each_call=trim($_REQUEST["pause_after_each_call"]);
$no_hopper_dialing=trim($_REQUEST["no_hopper_dialing"]);
$agent_dial_owner_only=trim($_REQUEST["agent_dial_owner_only"]);
$reset_time=trim($_REQUEST["reset_time"]);
$allow_alerts=trim($_REQUEST["allow_alerts"]);
$agent_display_dialable_leads=trim($_REQUEST["agent_display_dialable_leads"]);
$vicidial_balance_rank=trim($_REQUEST["vicidial_balance_rank"]);
$agent_script_override=trim($_REQUEST["agent_script_override"]);
$moh_id=trim($_REQUEST["moh_id"]);
$moh_name=trim($_REQUEST["moh_name"]);
$random=trim($_REQUEST["random"]);
$filename=trim($_REQUEST["filename"]);
$rank=trim($_REQUEST["rank"]);
$rebuild_music_on_hold=trim($_REQUEST["rebuild_music_on_hold"]);
$active_agent_login_server=trim($_REQUEST["active_agent_login_server"]);
$enable_second_webform=trim($_REQUEST["enable_second_webform"]);
$web_form_address_two=trim($_REQUEST["web_form_address_two"]);
$waitforsilence_options=trim($_REQUEST["waitforsilence_options"]);
$campaign_cid_override=trim($_REQUEST["campaign_cid_override"]);
$am_message_exten_override=trim($_REQUEST["am_message_exten_override"]);
$drop_inbound_group_override=trim($_REQUEST["drop_inbound_group_override"]);
$agent_select_territories=trim($_REQUEST["agent_select_territories"]);
$agent_choose_territories=trim($_REQUEST["agent_choose_territories"]);
$carrier_description=trim($_REQUEST["carrier_description"]);
$delete_vm_after_email=trim($_REQUEST["delete_vm_after_email"]);
$custom_one=trim($_REQUEST["custom_one"]);
$custom_two=trim($_REQUEST["custom_two"]);
$custom_three=trim($_REQUEST["custom_three"]);
$custom_four=trim($_REQUEST["custom_four"]);
$custom_five=trim($_REQUEST["custom_five"]);
$crm_popup_login=trim($_REQUEST["crm_popup_login"]);
$crm_login_address=trim($_REQUEST["crm_login_address"]);
$timer_action=trim($_REQUEST["timer_action"]);
$timer_action_message=trim($_REQUEST["timer_action_message"]);
$timer_action_seconds=trim($_REQUEST["timer_action_seconds"]);
$start_call_url=trim($_REQUEST["start_call_url"]);
$dispo_call_url=trim($_REQUEST["dispo_call_url"]);
$xferconf_c_number=trim($_REQUEST["xferconf_c_number"]);
$xferconf_d_number=trim($_REQUEST["xferconf_d_number"]);
$xferconf_e_number=trim($_REQUEST["xferconf_e_number"]);

$field_id=trim($_REQUEST["field_id"]);
$field_label=trim($_REQUEST["field_label"]);
$field_name=trim($_REQUEST["field_name"]);
$field_type=trim($_REQUEST["field_type"]);
$field_option=trim($_REQUEST["field_option"]);
$field_description=trim($_REQUEST["field_description"]);
$field_default=trim($_REQUEST["field_default"]);

$do_actions=trim($_REQUEST["do_actions"]);




if (isset($script_id)) {$script_id= strtoupper($script_id);}
if (isset($lead_filter_id)) {$lead_filter_id = strtoupper($lead_filter_id);}


if($delete_users==""){$delete_users="0";}

if($delete_user_groups==""){$delete_user_groups="0";}

if($delete_lists==""){$delete_lists="0";}

if($delete_campaigns==""){$delete_campaigns="0";}

if($delete_ingroups==""){$delete_ingroups="0";}

if($delete_remote_agents==""){$delete_remote_agents="0";}
if($load_leads==""){$load_leads="0";}

if($campaign_detail==""){$campaign_detail="0";}

if($ast_admin_access==""){$ast_admin_access="0";}

if($ast_delete_phones==""){$ast_delete_phones="0";}

if($delete_scripts==""){$delete_scripts="0";}

if($modify_leads==""){$modify_leads="0";}

if($hotkeys_active==""){$hotkeys_active="0";}

if($change_agent_campaign==""){$change_agent_campaign="0";}

if($agent_choose_ingroups==""){$agent_choose_ingroups="0";}
if($scheduled_callbacks==""){$scheduled_callbacks="1";}

if($agentonly_callbacks==""){$agentonly_callbacks="0";}

if($agentcall_manual==""){$agentcall_manual="0";}

if($vicidial_recording==""){$vicidial_recording="0";}

if($vicidial_transfers==""){$vicidial_transfers="0";}

if($delete_filters==""){$delete_filters="0";}

if($alter_agent_interface_options==""){$alter_agent_interface_options="0";}

if($closer_default_blended==""){$closer_default_blended="0";}

if($delete_call_times==""){$delete_call_times="0";}

if($modify_call_times==""){$modify_call_times="0";}

if($modify_users==""){$modify_users="0";}

if($modify_campaigns==""){$modify_campaigns="0";}
if($modify_lists==""){$modify_lists="0";}

if($modify_scripts==""){$modify_scripts="0";}

if($modify_filters==""){$modify_filters="0";}

if($modify_ingroups==""){$modify_ingroups="0";}

if($modify_usergroups==""){$modify_usergroups="0";}

if($modify_remoteagents==""){$modify_remoteagents="0";}

if($modify_servers==""){$modify_servers="0";}

if($view_reports==""){$view_reports="0";}

if($vicidial_recording_override==""){$vicidial_recording_override="DISABLED";}

if($alter_custdata_override==""){$alter_custdata_override="NOT_ACTIVE";}

if($qc_enabled==""){$qc_enabled="0";}

if($qc_user_level==""){$qc_user_level="0";}

if($qc_pass==""){$qc_pass="0";}

if($qc_finish==""){$qc_finish="0";}

if($qc_commit==""){$qc_commit="0";}

if($add_timeclock_log==""){$add_timeclock_log="0";}

if($modify_timeclock_log==""){$modify_timeclock_log="0";}

if($delete_timeclock_log==""){$delete_timeclock_log="0";}

if($alter_custphone_override==""){$alter_custphone_override="NOT_ACTIVE";}

if($vdc_agent_api_access==""){$vdc_agent_api_access="0";}

if($modify_inbound_dids==""){$modify_inbound_dids="0";}

if($delete_inbound_dids==""){$delete_inbound_dids="0";}

//if($active==""){$active="Y";}

if($alert_enabled==""){$alert_enabled="0";}

if($download_lists==""){$download_lists="0";}

if($agent_shift_enforcement_override==""){$agent_shift_enforcement_override="DISABLED";}

if($manager_shift_enforcement_override==""){$manager_shift_enforcement_override="0";}

if($shift_override_flag==""){$shift_override_flag="0";}

if($export_reports==""){$export_reports="0";}

if($delete_from_dnc==""){$delete_from_dnc="0";}

if($allow_alerts==""){$allow_alerts="0";}

if($agent_choose_territories==""){$agent_choose_territories="1";}

//$server_ip=$db_host;
$extension=trim($_REQUEST["user"]);
$login=trim($_REQUEST["user"]);
  
$phone_type="CCagent";
$fullname=trim($_REQUEST["full_name"]);
if($protocol==""){
	$protocol="SIP";
}
$local_gmt="8.00";
$outbound_cid="0000000000";
$conf_secret=trim($_REQUEST["user"]);

$old_group=trim($_REQUEST["old_group"]);
$group=trim($_REQUEST["group"]);
$stage=trim($_REQUEST["stage"]);

$adaptive_latest_server_time = ereg_replace("[^0-9]","",$adaptive_latest_server_time);
$admin_hangup_enabled = ereg_replace("[^0-9]","",$admin_hangup_enabled);
$admin_hijack_enabled = ereg_replace("[^0-9]","",$admin_hijack_enabled);
$admin_monitor_enabled = ereg_replace("[^0-9]","",$admin_monitor_enabled);
$AFLogging_enabled = ereg_replace("[^0-9]","",$AFLogging_enabled);
$agent_choose_ingroups = ereg_replace("[^0-9]","",$agent_choose_ingroups);
$agentcall_manual = ereg_replace("[^0-9]","",$agentcall_manual);
$agentonly_callbacks = ereg_replace("[^0-9]","",$agentonly_callbacks);
$AGI_call_logging_enabled = ereg_replace("[^0-9]","",$AGI_call_logging_enabled);
$allcalls_delay = ereg_replace("[^0-9]","",$allcalls_delay);
$alter_agent_interface_options = ereg_replace("[^0-9]","",$alter_agent_interface_options);
$answer_transfer_agent = ereg_replace("[^0-9]","",$answer_transfer_agent);
$ast_admin_access = ereg_replace("[^0-9]","",$ast_admin_access);
$ast_delete_phones = ereg_replace("[^0-9]","",$ast_delete_phones);
$attempt_delay = ereg_replace("[^0-9]","",$attempt_delay);
$attempt_maximum = ereg_replace("[^0-9]","",$attempt_maximum);
$auto_dial_next_number = ereg_replace("[^0-9]","",$auto_dial_next_number);
$balance_trunks_offlimits = ereg_replace("[^0-9]","",$balance_trunks_offlimits);
$call_parking_enabled = ereg_replace("[^0-9]","",$call_parking_enabled);
$CallerID_popup_enabled = ereg_replace("[^0-9]","",$CallerID_popup_enabled);
$campaign_detail = ereg_replace("[^0-9]","",$campaign_detail);
$campaign_rec_exten = ereg_replace("[^0-9]","",$campaign_rec_exten);
$campaign_vdad_exten = ereg_replace("[^0-9]","",$campaign_vdad_exten);
$change_agent_campaign = ereg_replace("[^0-9]","",$change_agent_campaign);
$closer_default_blended = ereg_replace("[^0-9]","",$closer_default_blended);
$conf_exten = ereg_replace("[^0-9]","",$conf_exten);
$conf_on_extension = ereg_replace("[^0-9]","",$conf_on_extension);
$conferencing_enabled = ereg_replace("[^0-9]","",$conferencing_enabled);
$ct_default_start = ereg_replace("[^0-9]","",$ct_default_start);
$ct_default_stop = ereg_replace("[^0-9]","",$ct_default_stop);
$ct_friday_start = ereg_replace("[^0-9]","",$ct_friday_start);
$ct_friday_stop = ereg_replace("[^0-9]","",$ct_friday_stop);
$ct_monday_start = ereg_replace("[^0-9]","",$ct_monday_start);
$ct_monday_stop = ereg_replace("[^0-9]","",$ct_monday_stop);
$ct_saturday_start = ereg_replace("[^0-9]","",$ct_saturday_start);
$ct_saturday_stop = ereg_replace("[^0-9]","",$ct_saturday_stop);
$ct_sunday_start = ereg_replace("[^0-9]","",$ct_sunday_start);
$ct_sunday_stop = ereg_replace("[^0-9]","",$ct_sunday_stop);
$ct_thursday_start = ereg_replace("[^0-9]","",$ct_thursday_start);
$ct_thursday_stop = ereg_replace("[^0-9]","",$ct_thursday_stop);
$ct_tuesday_start = ereg_replace("[^0-9]","",$ct_tuesday_start);
$ct_tuesday_stop = ereg_replace("[^0-9]","",$ct_tuesday_stop);
$ct_wednesday_start = ereg_replace("[^0-9]","",$ct_wednesday_start);
$ct_wednesday_stop = ereg_replace("[^0-9]","",$ct_wednesday_stop);
$DBX_port = ereg_replace("[^0-9]","",$DBX_port);
$dedicated_trunks = ereg_replace("[^0-9]","",$dedicated_trunks);
$delete_call_times = ereg_replace("[^0-9]","",$delete_call_times);
$delete_campaigns = ereg_replace("[^0-9]","",$delete_campaigns);
$delete_filters = ereg_replace("[^0-9]","",$delete_filters);
$delete_ingroups = ereg_replace("[^0-9]","",$delete_ingroups);
$delete_lists = ereg_replace("[^0-9]","",$delete_lists);
$delete_remote_agents = ereg_replace("[^0-9]","",$delete_remote_agents);
$delete_scripts = ereg_replace("[^0-9]","",$delete_scripts);
$delete_user_groups = ereg_replace("[^0-9]","",$delete_user_groups);
$delete_users = ereg_replace("[^0-9]","",$delete_users);
$dial_timeout = ereg_replace("[^0-9]","",$dial_timeout);
$dialplan_number = ereg_replace("[^0-9]","",$dialplan_number);
$enable_fast_refresh = ereg_replace("[^0-9]","",$enable_fast_refresh);
$enable_persistant_mysql = ereg_replace("[^0-9]","",$enable_persistant_mysql);
$fast_refresh_rate = ereg_replace("[^0-9]","",$fast_refresh_rate);
$hopper_level = ereg_replace("[^0-9]","",$hopper_level);
$hotkey = ereg_replace("[^0-9]","",$hotkey);
$hotkeys_active = ereg_replace("[^0-9]","",$hotkeys_active);
//$list_id = ereg_replace("[^0-9]","",$list_id);
$load_leads = ereg_replace("[^0-9]","",$load_leads);
$max_vicidial_trunks = ereg_replace("[^0-9]","",$max_vicidial_trunks);
$modify_call_times = ereg_replace("[^0-9]","",$modify_call_times);
$modify_users = ereg_replace("[^0-9]","",$modify_users);
$modify_campaigns = ereg_replace("[^0-9]","",$modify_campaigns);
$modify_lists = ereg_replace("[^0-9]","",$modify_lists);
$modify_scripts = ereg_replace("[^0-9]","",$modify_scripts);
$modify_filters = ereg_replace("[^0-9]","",$modify_filters);
$modify_ingroups = ereg_replace("[^0-9]","",$modify_ingroups);
$modify_usergroups = ereg_replace("[^0-9]","",$modify_usergroups);
$modify_remoteagents = ereg_replace("[^0-9]","",$modify_remoteagents);
$modify_servers = ereg_replace("[^0-9]","",$modify_servers);
$view_reports = ereg_replace("[^0-9]","",$view_reports);
$modify_leads = ereg_replace("[^0-9]","",$modify_leads);
$monitor_prefix = ereg_replace("[^0-9]","",$monitor_prefix);
$number_of_lines = ereg_replace("[^0-9]","",$number_of_lines);
$old_conf_exten = ereg_replace("[^0-9]","",$old_conf_exten);
$outbound_cid = ereg_replace("[^0-9]","",$outbound_cid);
$park_ext = ereg_replace("[^0-9]","",$park_ext);
$park_on_extension = ereg_replace("[^0-9]","",$park_on_extension);
$phone_number = ereg_replace("[^0-9]","",$phone_number);
$QUEUE_ACTION_enabled = ereg_replace("[^0-9]","",$QUEUE_ACTION_enabled);
$recording_exten = ereg_replace("[^0-9]","",$recording_exten);
$remote_agent_id = ereg_replace("[^0-9]","",$remote_agent_id);
$telnet_port = ereg_replace("[^0-9]","",$telnet_port);
$updater_check_enabled = ereg_replace("[^0-9]","",$updater_check_enabled);
$user_level = ereg_replace("[^0-9]","",$user_level);
$user_start = ereg_replace("[^0-9]","",$user_start);
$user_switching_enabled = ereg_replace("[^0-9]","",$user_switching_enabled);
$VDstop_rec_after_each_call = ereg_replace("[^0-9]","",$VDstop_rec_after_each_call);
$VICIDIAL_park_on_extension = ereg_replace("[^0-9]","",$VICIDIAL_park_on_extension);
$vicidial_recording = ereg_replace("[^0-9]","",$vicidial_recording);
$vicidial_transfers = ereg_replace("[^0-9]","",$vicidial_transfers);
$voicemail_button_enabled = ereg_replace("[^0-9]","",$voicemail_button_enabled);
$voicemail_dump_exten = ereg_replace("[^0-9]","",$voicemail_dump_exten);
$voicemail_ext = ereg_replace("[^0-9]","",$voicemail_ext);
$voicemail_exten = ereg_replace("[^0-9]","",$voicemail_exten);
$wrapup_seconds = ereg_replace("[^0-9]","",$wrapup_seconds);
$use_non_latin = ereg_replace("[^0-9]","",$use_non_latin);
$webroot_writable = ereg_replace("[^0-9]","",$webroot_writable);
$enable_queuemetrics_logging = ereg_replace("[^0-9]","",$enable_queuemetrics_logging);
$enable_sipsak_messages = ereg_replace("[^0-9]","",$enable_sipsak_messages);
$allow_sipsak_messages = ereg_replace("[^0-9]","",$allow_sipsak_messages);
$mix_container_item = ereg_replace("[^0-9]","",$mix_container_item);
$prompt_interval = ereg_replace("[^0-9]","",$prompt_interval);
$agent_alert_delay = ereg_replace("[^0-9]","",$agent_alert_delay);
$manual_dial_list_id = ereg_replace("[^0-9]","",$manual_dial_list_id);
$qc_user_level = ereg_replace("[^0-9]","",$qc_user_level);

$qc_pass = ereg_replace("[^0-9]","",$qc_pass);
$qc_finish = ereg_replace("[^0-9]","",$qc_finish);
$qc_commit = ereg_replace("[^0-9]","",$qc_commit);
$shift_start_time = ereg_replace("[^0-9]","",$shift_start_time);
$timeclock_end_of_day = ereg_replace("[^0-9]","",$timeclock_end_of_day);
$survey_xfer_exten = ereg_replace("[^0-9]","",$survey_xfer_exten);
$add_timeclock_log = ereg_replace("[^0-9]","",$add_timeclock_log);
$modify_timeclock_log = ereg_replace("[^0-9]","",$modify_timeclock_log);
$delete_timeclock_log = ereg_replace("[^0-9]","",$delete_timeclock_log);
$vdc_agent_api_access = ereg_replace("[^0-9]","",$vdc_agent_api_access);
$vdc_agent_api_active = ereg_replace("[^0-9]","",$vdc_agent_api_active);
$hold_time_option_seconds = ereg_replace("[^0-9]","",$hold_time_option_seconds);
$hold_time_option_callback_list_id = ereg_replace("[^0-9]","",$hold_time_option_callback_list_id);
$did_id = ereg_replace("[^0-9]","",$did_id);
$source_did = ereg_replace("[^0-9]","",$source_did);
$modify_inbound_dids = ereg_replace("[^0-9]","",$modify_inbound_dids);
$delete_inbound_dids = ereg_replace("[^0-9]","",$delete_inbound_dids);
$answer_sec_pct_rt_stat_one = ereg_replace("[^0-9]","",$answer_sec_pct_rt_stat_one);
$answer_sec_pct_rt_stat_two = ereg_replace("[^0-9]","",$answer_sec_pct_rt_stat_two);
$enable_vtiger_integration = ereg_replace("[^0-9]","",$enable_vtiger_integration);
$qc_features_active = ereg_replace("[^0-9]","",$qc_features_active);
$outbound_autodial_active = ereg_replace("[^0-9]","",$outbound_autodial_active);
$download_lists = ereg_replace("[^0-9]","",$download_lists);
$caller_id_number = ereg_replace("[^0-9]","",$caller_id_number);
$outbound_calls_per_second = ereg_replace("[^0-9]","",$outbound_calls_per_second);
$manager_shift_enforcement_override = ereg_replace("[^0-9]","",$manager_shift_enforcement_override);
$export_reports = ereg_replace("[^0-9]","",$export_reports);
$delete_from_dnc = ereg_replace("[^0-9]","",$delete_from_dnc);
$menu_timeout = ereg_replace("[^0-9]","",$menu_timeout);
$menu_time_check = ereg_replace("[^0-9]","",$menu_time_check);
$track_in_vdac = ereg_replace("[^0-9]","",$track_in_vdac);
$menu_repeat = ereg_replace("[^0-9]","",$menu_repeat);
$agentonly_callback_campaign_lock = ereg_replace("[^0-9]","",$agentonly_callback_campaign_lock);
$sounds_central_control_active = ereg_replace("[^0-9]","",$sounds_central_control_active);
$user_territories_active = ereg_replace("[^0-9]","",$user_territories_active);
$vicidial_recording_limit = ereg_replace("[^0-9]","",$vicidial_recording_limit);
$allow_custom_dialplan = ereg_replace("[^0-9]","",$allow_custom_dialplan);
$phone_ring_timeout = ereg_replace("[^0-9]","",$phone_ring_timeout);
$enable_tts_integration = ereg_replace("[^0-9]","",$enable_tts_integration);
$allow_alerts = ereg_replace("[^0-9]","",$allow_alerts);
$vicidial_balance_rank = ereg_replace("[^0-9]","",$vicidial_balance_rank);
$rank = ereg_replace("[^0-9]","",$rank);
$enable_second_webform = ereg_replace("[^0-9]","",$enable_second_webform);
$campaign_cid_override = ereg_replace("[^0-9]","",$campaign_cid_override);
$agent_choose_territories = ereg_replace("[^0-9]","",$agent_choose_territories);
$timer_action_seconds = ereg_replace("[^0-9]","",$timer_action_seconds);

$drop_call_seconds = ereg_replace("[^-0-9]","",$drop_call_seconds);

### DIGITS and COLONS
$shift_length = ereg_replace("[^\:0-9]","",$shift_length);

### DIGITS and HASHES and STARS
$survey_dtmf_digits = ereg_replace("[^\#\*0-9]","",$survey_dtmf_digits);
$survey_ni_digit = ereg_replace("[^\#\*0-9]","",$survey_ni_digit);

### DIGITS and DASHES
$group_rank = ereg_replace("[^-0-9]","",$group_rank);
$campaign_rank = ereg_replace("[^-0-9]","",$campaign_rank);
$queue_priority = ereg_replace("[^-0-9]","",$queue_priority);

### DIGITS and NEWLINES
$phone_numbers = ereg_replace("[^X\n0-9]","",$phone_numbers);

### Y or N ONLY ###
$allow_closers = ereg_replace("[^NY]","",$allow_closers);
$reset_hopper = ereg_replace("[^NY]","",$reset_hopper);
$amd_send_to_vmx = ereg_replace("[^NY]","",$amd_send_to_vmx);
$alt_number_dialing = ereg_replace("[^NY]","",$alt_number_dialing);
$selectable = ereg_replace("[^NY]","",$selectable);
$reset_list = ereg_replace("[^NY]","",$reset_list);
$fronter_display = ereg_replace("[^NY]","",$fronter_display);
$omit_phone_code = ereg_replace("[^NY]","",$omit_phone_code);
$available_only_ratio_tally = ereg_replace("[^NY]","",$available_only_ratio_tally);
$sys_perf_log = ereg_replace("[^NY]","",$sys_perf_log);
$vicidial_balance_active = ereg_replace("[^NY]","",$vicidial_balance_active);
$vd_server_logs = ereg_replace("[^NY]","",$vd_server_logs);
$campaign_stats_refresh = ereg_replace("[^NY]","",$campaign_stats_refresh);
$disable_alter_custdata = ereg_replace("[^NY]","",$disable_alter_custdata);
$no_hopper_leads_logins = ereg_replace("[^NY]","",$no_hopper_leads_logins);
$human_answered = ereg_replace("[^NY]","",$human_answered);
$tovdad_display = ereg_replace("[^NY]","",$tovdad_display);
$campaign_allow_inbound = ereg_replace("[^NY]","",$campaign_allow_inbound);
$display_queue_count = ereg_replace("[^NY]","",$display_queue_count);
$qc_show_recording = ereg_replace("[^NY]","",$qc_show_recording);
$sale_category = ereg_replace("[^NY]","",$sale_category);
$dead_lead_category = ereg_replace("[^NY]","",$dead_lead_category);
$agent_extended_alt_dial  = ereg_replace("[^NY]","",$agent_extended_alt_dial);
$play_place_in_line  = ereg_replace("[^NY]","",$play_place_in_line);
$play_estimate_hold_time  = ereg_replace("[^NY]","",$play_estimate_hold_time);
$no_delay_call_route  = ereg_replace("[^NY]","",$no_delay_call_route);
$did_active  = ereg_replace("[^NY]","",$did_active);
$active_asterisk_server = ereg_replace("[^NY]","",$active_asterisk_server);
$generate_vicidial_conf = ereg_replace("[^NY]","",$generate_vicidial_conf);
$rebuild_conf_files = ereg_replace("[^NY]","",$rebuild_conf_files);
$agent_allow_group_alias = ereg_replace("[^NY]","",$agent_allow_group_alias);
$vtiger_status_call = ereg_replace("[^NY]","",$vtiger_status_call);
$sale = ereg_replace("[^NY]","",$sale);
$dnc = ereg_replace("[^NY]","",$dnc);
$customer_contact = ereg_replace("[^NY]","",$customer_contact);
$not_interested = ereg_replace("[^NY]","",$not_interested);
$unworkable = ereg_replace("[^NY]","",$unworkable);
$sounds_update = ereg_replace("[^NY]","",$sounds_update);
$carrier_logging_active = ereg_replace("[^NY]","",$carrier_logging_active);
$agent_status_view_time = ereg_replace("[^NY]","",$agent_status_view_time);
$no_hopper_dialing = ereg_replace("[^NY]","",$no_hopper_dialing);
$agent_display_dialable_leads = ereg_replace("[^NY]","",$agent_display_dialable_leads);
$random = ereg_replace("[^NY]","",$random);
$rebuild_music_on_hold = ereg_replace("[^NY]","",$rebuild_music_on_hold);
$active_agent_login_server = ereg_replace("[^NY]","",$active_agent_login_server);
$agent_select_territories = ereg_replace("[^NY]","",$agent_select_territories);
$delete_vm_after_email = ereg_replace("[^NY]","",$delete_vm_after_email);
$crm_popup_login = ereg_replace("[^NY]","",$crm_popup_login);

$qc_enabled = ereg_replace("[^0-9NY]","",$qc_enabled);
$active = ereg_replace("[^0-9NY]","",$active);


### ALPHA-NUMERIC ONLY ###
//$script_id = ereg_replace("[^0-9a-zA-Z]","",$script_id);
//$agent_script_override = ereg_replace("[^0-9a-zA-Z]","",$agent_script_override);
$campaign_script = ereg_replace("[^0-9a-zA-Z]","",$campaign_script);
$submit = ereg_replace("[^0-9a-zA-Z]","",$submit);
$campaign_cid = ereg_replace("[^0-9a-zA-Z]","",$campaign_cid);
$get_call_launch = ereg_replace("[^0-9a-zA-Z]","",$get_call_launch);
$campaign_recording = ereg_replace("[^0-9a-zA-Z]","",$campaign_recording);
$ADD = ereg_replace("[^0-9a-zA-Z]","",$ADD);
$dial_prefix = ereg_replace("[^0-9a-zA-Z]","",$dial_prefix);
$state_call_time_state = ereg_replace("[^0-9a-zA-Z]","",$state_call_time_state);
$scheduled_callbacks = ereg_replace("[^0-9a-zA-Z]","",$scheduled_callbacks);
$concurrent_transfers = ereg_replace("[^0-9a-zA-Z]","",$concurrent_transfers);
$billable = ereg_replace("[^0-9a-zA-Z]","",$billable);
$pause_code = ereg_replace("[^\,0-9a-zA-Z]","",$pause_code);
$vicidial_recording_override = ereg_replace("[^0-9a-zA-Z]","",$vicidial_recording_override);
$ingroup_recording_override = ereg_replace("[^0-9a-zA-Z]","",$ingroup_recording_override);
$queuemetrics_log_id = ereg_replace("[^0-9a-zA-Z]","",$queuemetrics_log_id);
$after_hours_exten = ereg_replace("[^0-9a-zA-Z]","",$after_hours_exten);
$after_hours_voicemail = ereg_replace("[^0-9a-zA-Z]","",$after_hours_voicemail);
$qc_script = ereg_replace("[^0-9a-zA-Z]","",$qc_script);
$code = ereg_replace("[^0-9a-zA-Z]","",$code);
$survey_no_response_action = ereg_replace("[^0-9a-zA-Z]","",$survey_no_response_action);
$survey_ni_status = ereg_replace("[^0-9a-zA-Z]","",$survey_ni_status);
$qc_get_record_launch = ereg_replace("[^0-9a-zA-Z]","",$qc_get_record_launch);
$agent_pause_codes_active = ereg_replace("[^0-9a-zA-Z]","",$agent_pause_codes_active);
$three_way_dial_prefix = ereg_replace("[^0-9a-zA-Z]","",$three_way_dial_prefix);
$shift_enforcement = ereg_replace("[^0-9a-zA-Z]","",$shift_enforcement);
$agent_shift_enforcement_override = ereg_replace("[^0-9a-zA-Z]","",$agent_shift_enforcement_override);
$survey_third_status = ereg_replace("[^0-9a-zA-Z]","",$survey_third_status);
$survey_fourth_status = ereg_replace("[^0-9a-zA-Z]","",$survey_fourth_status);
$sounds_web_directory = ereg_replace("[^0-9a-zA-Z]","",$sounds_web_directory);
$disable_alter_custphone = ereg_replace("[^0-9a-zA-Z]","",$disable_alter_custphone);
$view_calls_in_queue = ereg_replace("[^0-9a-zA-Z]","",$view_calls_in_queue);
$view_calls_in_queue_launch = ereg_replace("[^0-9a-zA-Z]","",$view_calls_in_queue_launch);
$grab_calls_in_queue = ereg_replace("[^0-9a-zA-Z]","",$grab_calls_in_queue);
$call_requeue_button = ereg_replace("[^0-9a-zA-Z]","",$call_requeue_button);
$pause_after_each_call = ereg_replace("[^0-9a-zA-Z]","",$pause_after_each_call);
$use_internal_dnc = ereg_replace("[^0-9a-zA-Z]","",$use_internal_dnc);
$use_campaign_dnc = ereg_replace("[^0-9a-zA-Z]","",$use_campaign_dnc);
$voicemail_id = ereg_replace("[^0-9a-zA-Z]","",$voicemail_id);
$status_id = ereg_replace("[^0-9a-zA-Z]","",$status_id);

### DIGITS and Dots
$server_ip = ereg_replace("[^\.0-9]","",$server_ip);
$auto_dial_level = ereg_replace("[^\.0-9]","",$auto_dial_level);
$adaptive_maximum_level = ereg_replace("[^\.0-9]","",$adaptive_maximum_level);
$phone_ip = ereg_replace("[^\.0-9]","",$phone_ip);
$old_server_ip = ereg_replace("[^\.0-9]","",$old_server_ip);
$computer_ip = ereg_replace("[^\.0-9]","",$computer_ip);
$queuemetrics_server_ip = ereg_replace("[^\.0-9]","",$queuemetrics_server_ip);
$vtiger_server_ip = ereg_replace("[^\.0-9]","",$vtiger_server_ip);
$active_voicemail_server = ereg_replace("[^\.0-9]","",$active_voicemail_server);
$auto_dial_limit = ereg_replace("[^\.0-9]","",$auto_dial_limit);
$adaptive_dropped_percentage = ereg_replace("[^\.0-9]","",$adaptive_dropped_percentage);
$drop_lockout_time = ereg_replace("[^\.0-9]","",$drop_lockout_time);

$xferconf_a_dtmf = ereg_replace("[^ \,\*\#0-9a-zA-Z]","",$xferconf_a_dtmf);
$xferconf_b_dtmf = ereg_replace("[^ \,\*\#0-9a-zA-Z]","",$xferconf_b_dtmf);
$xferconf_c_dtmf = ereg_replace("[^ \,\*\#0-9a-zA-Z]","",$xferconf_c_dtmf);
$xferconf_d_dtmf = ereg_replace("[^ \,\*\#0-9a-zA-Z]","",$xferconf_d_dtmf);
$xferconf_e_dtmf = ereg_replace("[^ \,\*\#0-9a-zA-Z]","",$xferconf_e_dtmf);
$survey_third_digit = ereg_replace("[^ \,\*\#0-9a-zA-Z]","",$survey_third_digit);
$survey_fourth_digit = ereg_replace("[^ \,\*\#0-9a-zA-Z]","",$survey_fourth_digit);
$survey_third_exten = ereg_replace("[^ \,\*\#0-9a-zA-Z]","",$survey_third_exten);
$survey_fourth_exten = ereg_replace("[^ \,\*\#0-9a-zA-Z]","",$survey_fourth_exten);

$xferconf_a_number = ereg_replace("[^0-9A-Z]","",$xferconf_a_number);
$xferconf_b_number = ereg_replace("[^0-9A-Z]","",$xferconf_b_number);

$agi_output = ereg_replace("[^-_0-9a-zA-Z]","",$agi_output);
$ASTmgrSECRET = ereg_replace("[^-_0-9a-zA-Z]","",$ASTmgrSECRET);
$ASTmgrUSERNAME = ereg_replace("[^-_0-9a-zA-Z]","",$ASTmgrUSERNAME);
$ASTmgrUSERNAMElisten = ereg_replace("[^-_0-9a-zA-Z]","",$ASTmgrUSERNAMElisten);
$ASTmgrUSERNAMEsend = ereg_replace("[^-_0-9a-zA-Z]","",$ASTmgrUSERNAMEsend);
$ASTmgrUSERNAMEupdate = ereg_replace("[^-_0-9a-zA-Z]","",$ASTmgrUSERNAMEupdate);
$call_time_id = ereg_replace("[^-_0-9a-zA-Z]","",$call_time_id);
//$campaign_id = ereg_replace("[^-_0-9a-zA-Z]","",$campaign_id);
$CoNfIrM = ereg_replace("[^-_0-9a-zA-Z]","",$CoNfIrM);
$DBX_database = ereg_replace("[^-_0-9a-zA-Z]","",$DBX_database);
$DBX_pass = ereg_replace("[^-_0-9a-zA-Z]","",$DBX_pass);
$DBX_user = ereg_replace("[^-_0-9a-zA-Z]","",$DBX_user);
$DBY_database = ereg_replace("[^-_0-9a-zA-Z]","",$DBY_database);
$DBY_pass = ereg_replace("[^-_0-9a-zA-Z]","",$DBY_pass);
$DBY_user = ereg_replace("[^-_0-9a-zA-Z]","",$DBY_user);
$dial_method = ereg_replace("[^-_0-9a-zA-Z]","",$dial_method);
$dial_status_a = ereg_replace("[^-_0-9a-zA-Z]","",$dial_status_a);
$dial_status_b = ereg_replace("[^-_0-9a-zA-Z]","",$dial_status_b);
$dial_status_c = ereg_replace("[^-_0-9a-zA-Z]","",$dial_status_c);
$dial_status_d = ereg_replace("[^-_0-9a-zA-Z]","",$dial_status_d);
$dial_status_e = ereg_replace("[^-_0-9a-zA-Z]","",$dial_status_e);
$ext_context = ereg_replace("[^-_0-9a-zA-Z]","",$ext_context);
$group_id = ereg_replace("[^-_0-9a-zA-Z]","",$group_id);
$lead_filter_id = ereg_replace("[^-_0-9a-zA-Z]","",$lead_filter_id);
$local_call_time = ereg_replace("[^-_0-9a-zA-Z]","",$local_call_time);
$login = ereg_replace("[^-_0-9a-zA-Z]","",$login);
$login_campaign = ereg_replace("[^-_0-9a-zA-Z]","",$login_campaign);
$login_pass = ereg_replace("[^-_0-9a-zA-Z]","",$login_pass);
$login_user = ereg_replace("[^-_0-9a-zA-Z]","",$login_user);
$next_agent_call = ereg_replace("[^-_0-9a-zA-Z]","",$next_agent_call);
$old_campaign_id = ereg_replace("[^-_0-9a-zA-Z]","",$old_campaign_id);
$old_server_id = ereg_replace("[^-_0-9a-zA-Z]","",$old_server_id);
$OLDuser_group = ereg_replace("[^-_0-9a-zA-Z]","",$OLDuser_group);
//$park_file_name = ereg_replace("[^-_0-9a-zA-Z]","",$park_file_name);
$pass = ereg_replace("[^-_0-9a-zA-Z]","",$pass);
$phone_login = ereg_replace("[^-_0-9a-zA-Z]","",$phone_login);
$phone_pass = ereg_replace("[^-_0-9a-zA-Z]","",$phone_pass);
$PHP_AUTH_PW = ereg_replace("[^-_0-9a-zA-Z]","",$PHP_AUTH_PW);
$PHP_AUTH_USER = ereg_replace("[^-_0-9a-zA-Z]","",$PHP_AUTH_USER);
$protocol = ereg_replace("[^-_0-9a-zA-Z]","",$protocol);
$server_id = ereg_replace("[^-_0-9a-zA-Z]","",$server_id);
$stage = ereg_replace("[^-_0-9a-zA-Z]","",$stage);
$state_rule = ereg_replace("[^-_0-9a-zA-Z]","",$state_rule);
$trunk_restriction = ereg_replace("[^-_0-9a-zA-Z]","",$trunk_restriction);
$user = ereg_replace("[^-_0-9a-zA-Z]","",$user);
$user_group = ereg_replace("[^-_0-9a-zA-Z]","",$user_group);
$VICIDIAL_park_on_filename = ereg_replace("[^-_0-9a-zA-Z]","",$VICIDIAL_park_on_filename);
$auto_alt_dial = ereg_replace("[^-_0-9a-zA-Z]","",$auto_alt_dial);
$dial_status = ereg_replace("[^-_0-9a-zA-Z]","",$dial_status);
$queuemetrics_eq_prepend = ereg_replace("[^-_0-9a-zA-Z]","",$queuemetrics_eq_prepend);
$vicidial_agent_disable = ereg_replace("[^-_0-9a-zA-Z]","",$vicidial_agent_disable);
$alter_custdata_override = ereg_replace("[^-_0-9a-zA-Z]","",$alter_custdata_override);
$list_order_mix = ereg_replace("[^-_0-9a-zA-Z]","",$list_order_mix);
$vcl_id = ereg_replace("[^-_0-9a-zA-Z]","",$vcl_id);
$mix_method = ereg_replace("[^-_0-9a-zA-Z]","",$mix_method);
$category = ereg_replace("[^-_0-9a-zA-Z]","",$category);
$vsc_id = ereg_replace("[^-_0-9a-zA-Z]","",$vsc_id);
$moh_context = ereg_replace("[^-_0-9a-zA-Z]","",$moh_context);
$source_campaign_id = ereg_replace("[^-_0-9a-zA-Z]","",$source_campaign_id);
$source_user_id = ereg_replace("[^-_0-9a-zA-Z]","",$source_user_id);
$source_group_id = ereg_replace("[^-_0-9a-zA-Z]","",$source_group_id);
$default_xfer_group = ereg_replace("[^-_0-9a-zA-Z]","",$default_xfer_group);
$drop_exten = ereg_replace("[^-_0-9a-zA-Z]","",$drop_exten);
$safe_harbor_exten = ereg_replace("[^-_0-9a-zA-Z]","",$safe_harbor_exten);
$drop_action = ereg_replace("[^-_0-9a-zA-Z]","",$drop_action);
$drop_inbound_group = ereg_replace("[^-_0-9a-zA-Z]","",$drop_inbound_group);
$afterhours_xfer_group = ereg_replace("[^-_0-9a-zA-Z]","",$afterhours_xfer_group);
$after_hours_action = ereg_replace("[^-_0-9a-zA-Z]","",$after_hours_action);
$alias_id = ereg_replace("[^-_0-9a-zA-Z]","",$alias_id);
$shift_id = ereg_replace("[^-_0-9a-zA-Z]","",$shift_id);
$qc_shift_id = ereg_replace("[^-_0-9a-zA-Z]","",$qc_shift_id);
$survey_first_audio_file = ereg_replace("[^-_0-9a-zA-Z]","",$survey_first_audio_file);
$survey_opt_in_audio_file = ereg_replace("[^-_0-9a-zA-Z]","",$survey_opt_in_audio_file);
$survey_ni_audio_file = ereg_replace("[^-_0-9a-zA-Z]","",$survey_ni_audio_file);
$survey_method = ereg_replace("[^-_0-9a-zA-Z]","",$survey_method);
$alter_custphone_override = ereg_replace("[^-_0-9a-zA-Z]","",$alter_custphone_override);
$manual_dial_filter = ereg_replace("[^-_0-9a-zA-Z]","",$manual_dial_filter);
$agent_clipboard_copy = ereg_replace("[^-_0-9a-zA-Z]","",$agent_clipboard_copy);
$hold_time_option = ereg_replace("[^-_0-9a-zA-Z]","",$hold_time_option);
$hold_time_option_xfer_group = ereg_replace("[^-_0-9a-zA-Z]","",$hold_time_option_xfer_group);
$hold_recall_xfer_group = ereg_replace("[^-_0-9a-zA-Z]","",$hold_recall_xfer_group);
$play_welcome_message = ereg_replace("[^-_0-9a-zA-Z]","",$play_welcome_message);
$did_route = ereg_replace("[^-_0-9a-zA-Z]","",$did_route);
$user_unavailable_action = ereg_replace("[^-_0-9a-zA-Z]","",$user_unavailable_action);
$user_route_settings_ingroup = ereg_replace("[^-_0-9a-zA-Z]","",$user_route_settings_ingroup);
$call_handle_method = ereg_replace("[^-_0-9a-zA-Z]","",$call_handle_method);
$agent_search_method = ereg_replace("[^-_0-9a-zA-Z]","",$agent_search_method);
$hold_time_option_voicemail = ereg_replace("[^-_0-9a-zA-Z]","",$hold_time_option_voicemail);
$exten_context = ereg_replace("[^-_0-9a-zA-Z]","",$exten_context);
$three_way_call_cid = ereg_replace("[^-_0-9a-zA-Z]","",$three_way_call_cid);
$web_form_target = ereg_replace("[^-_0-9a-zA-Z]","",$web_form_target);
$recording_web_link = ereg_replace("[^-_0-9a-zA-Z]","",$recording_web_link);
$vtiger_search_category = ereg_replace("[^-_0-9a-zA-Z]","",$vtiger_search_category);
$vtiger_create_call_record = ereg_replace("[^-_0-9a-zA-Z]","",$vtiger_create_call_record);
$vtiger_create_lead_record = ereg_replace("[^-_0-9a-zA-Z]","",$vtiger_create_lead_record);
$vtiger_screen_login = ereg_replace("[^-_0-9a-zA-Z]","",$vtiger_screen_login);
$cpd_amd_action = ereg_replace("[^-_0-9a-zA-Z]","",$cpd_amd_action);
$template_id = ereg_replace("[^-_0-9a-zA-Z]","",$template_id);
$carrier_id = ereg_replace("[^-_0-9a-zA-Z]","",$carrier_id);
$group_alias_id = ereg_replace("[^-_0-9a-zA-Z]","",$group_alias_id);
$default_group_alias = ereg_replace("[^-_0-9a-zA-Z]","",$default_group_alias);
$vtiger_search_dead = ereg_replace("[^-_0-9a-zA-Z]","",$vtiger_search_dead);
$survey_third_audio_file = ereg_replace("[^-_0-9a-zA-Z]","",$survey_third_audio_file);
$survey_fourth_audio_file = ereg_replace("[^-_0-9a-zA-Z]","",$survey_fourth_audio_file);
$menu_id = ereg_replace("[^-_0-9a-zA-Z]","",$menu_id);
$source_menu = ereg_replace("[^-_0-9a-zA-Z]","",$source_menu);
$call_time_id = ereg_replace("[^-_0-9a-zA-Z]","",$call_time_id);
$phone_context = ereg_replace("[^-_0-9a-zA-Z]","",$phone_context);
$conf_secret = ereg_replace("[^-_0-9a-zA-Z]","",$conf_secret);
$tracking_group = ereg_replace("[^-_0-9a-zA-Z]","",$tracking_group);
$no_agent_no_queue = ereg_replace("[^-_0-9a-zA-Z]","",$no_agent_no_queue);
$no_agent_action = ereg_replace("[^-_0-9a-zA-Z]","",$no_agent_action);
$quick_transfer_button = ereg_replace("[^-_0-9a-zA-Z]","",$quick_transfer_button);
$prepopulate_transfer_preset = ereg_replace("[^-_0-9a-zA-Z]","",$prepopulate_transfer_preset);
$tts_id = ereg_replace("[^-_0-9a-zA-Z]","",$tts_id);
$drop_rate_group = ereg_replace("[^-_0-9a-zA-Z]","",$drop_rate_group);
$agent_dial_owner_only = ereg_replace("[^-_0-9a-zA-Z]","",$agent_dial_owner_only);
$reset_time = ereg_replace("[^-_0-9a-zA-Z]","",$reset_time);
$moh_id = ereg_replace("[^-_0-9a-zA-Z]","",$moh_id);
$drop_inbound_group_override = ereg_replace("[^-_0-9a-zA-Z]","",$drop_inbound_group_override);

$timer_action = ereg_replace("[^-_0-9a-zA-Z]","",$timer_action);

$menu_prompt = ereg_replace("[^-\/\|\._0-9a-zA-Z]","",$menu_prompt);
$menu_timeout_prompt = ereg_replace("[^-\/\|\._0-9a-zA-Z]","",$menu_timeout_prompt);
$menu_invalid_prompt = ereg_replace("[^-\/\|\._0-9a-zA-Z]","",$menu_invalid_prompt);
$after_hours_message_filename = ereg_replace("[^-\/\|\._0-9a-zA-Z]","",$after_hours_message_filename);
$welcome_message_filename = ereg_replace("[^-\/\|\._0-9a-zA-Z]","",$welcome_message_filename);
$onhold_prompt_filename = ereg_replace("[^-\/\|\._0-9a-zA-Z]","",$onhold_prompt_filename);
$hold_time_option_callback_filename = ereg_replace("[^-\/\|\._0-9a-zA-Z]","",$hold_time_option_callback_filename);
$agent_alert_exten = ereg_replace("[^-\|\/\._0-9a-zA-Z]","",$agent_alert_exten);
$filename = ereg_replace("[^-\/\._0-9a-zA-Z]","",$filename);
$am_message_exten = ereg_replace("[^-\|\/\._0-9a-zA-Z]","",$am_message_exten);
$am_message_exten_override = ereg_replace("[^-\|\/\._0-9a-zA-Z]","",$am_message_exten_override);
$logins_list = ereg_replace("[^-\,\_0-9a-zA-Z]","",$logins_list);
$forced_timeclock_login = ereg_replace("[^-\,\_0-9a-zA-Z]","",$forced_timeclock_login);
$sounds_web_server = ereg_replace("[^\.0-9a-zA-Z]","",$sounds_web_server);
$lead_order = ereg_replace("[^ 0-9a-zA-Z]","",$lead_order);

$group_color = ereg_replace("[^\#0-9a-zA-Z]","",$group_color);

$hold_time_option_exten = ereg_replace("[^\*\#\.\_0-9a-zA-Z]","",$hold_time_option_exten);
$did_pattern = ereg_replace("[^\*\#\.\_0-9a-zA-Z]","",$did_pattern);
$voicemail_ext = ereg_replace("[^\*\#\.\_0-9a-zA-Z]","",$voicemail_ext);
$phone = ereg_replace("[^\*\#\.\_0-9a-zA-Z]","",$phone);
$phone_code = ereg_replace("[^\*\#\.\_0-9a-zA-Z]","",$phone_code);

$adaptive_dl_diff_target = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$adaptive_dl_diff_target);
$adaptive_intensity = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$adaptive_intensity);
$asterisk_version = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$asterisk_version);
$call_time_comments = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$call_time_comments);
//$call_time_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$call_time_name);
//$campaign_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$campaign_name);
//$campaign_rec_filename = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$campaign_rec_filename);
//$ingroup_rec_filename = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$ingroup_rec_filename);
$company = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$company);
//$full_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$full_name);
//$fullname = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$fullname);
//$group_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$group_name);
$HKstatus = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$HKstatus);
//$lead_filter_comments = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$lead_filter_comments);
//$lead_filter_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$lead_filter_name);
//$list_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$list_name);
$local_gmt = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$local_gmt);
$phone_type = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$phone_type);
$picture = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$picture);
//$script_comments = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$script_comments);
//$script_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$script_name);
$server_description = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$server_description);
$status = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$status);
//$status_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$status_name);
$wrapup_message = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$wrapup_message);
//$pause_code_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$pause_code_name);
//$campaign_description = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$campaign_description);
//$list_description = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$list_description);
//$vcl_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$vcl_name);
//$vsc_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$vsc_name);
//$vsc_description = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$vsc_description);
//$code_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$code_name);
//$alias_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$alias_name);
//$shift_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$shift_name);
//$did_description = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$did_description);
$alt_server_ip = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$alt_server_ip);
//$template_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$template_name);
//$carrier_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$carrier_name);
//$group_alias_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$group_alias_name);
//$caller_id_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$caller_id_name);

//$tts_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$tts_name);
//$moh_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$moh_name);
$timer_action_message = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$timer_action_message);

$call_out_number_group = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$call_out_number_group);
$client_browser = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$client_browser);
$DBX_server = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$DBX_server);
$DBY_server = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$DBY_server);
$dtmf_send_extension = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$dtmf_send_extension);
$extension = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$extension);
$install_directory = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$install_directory);
$old_extension = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$old_extension);
$telnet_host = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$telnet_host);
$queuemetrics_dbname = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$queuemetrics_dbname);
$queuemetrics_login = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$queuemetrics_login);
$queuemetrics_pass = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$queuemetrics_pass);
$email = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$email);
$vtiger_dbname = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$vtiger_dbname);
$vtiger_login = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$vtiger_login);
$vtiger_pass = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$vtiger_pass);
$custom_one = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$custom_one);
$custom_two = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$custom_two);
$custom_three = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$custom_three);
$custom_four = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$custom_four);
$custom_five = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$custom_five);

$waitforsilence_options = ereg_replace("[^\|\,0-9]","",$waitforsilence_options);

$no_agent_action_value = ereg_replace("[^-\/\|\_\#\*\,\.\_0-9a-zA-Z]","",$no_agent_action_value);

$vdc_header_date_format = ereg_replace("[^- \:\/\_0-9a-zA-Z]","",$vdc_header_date_format);
$vdc_customer_date_format = ereg_replace("[^- \:\/\_0-9a-zA-Z]","",$vdc_customer_date_format);
//$menu_name = ereg_replace("[^- \:\/\_0-9a-zA-Z]","",$menu_name);

$vdc_header_phone_format = ereg_replace("[^- \(\)\_0-9a-zA-Z]","",$vdc_header_phone_format);

$lead_filter_sql = ereg_replace(";","",$lead_filter_sql);
$list_mix_container = ereg_replace(";","",$list_mix_container);
$survey_response_digit_map = ereg_replace(";","",$survey_response_digit_map);
$survey_camp_record_dir = ereg_replace(";","",$survey_camp_record_dir);
$conf_override = ereg_replace(";","",$conf_override);
$template_contents = ereg_replace(";","",$template_contents);
$registration_string = ereg_replace(";","",$registration_string);
$account_entry = ereg_replace(";","",$account_entry);
$account_entry = ereg_replace("\r","",$account_entry);
$globals_string = ereg_replace(";","",$globals_string);
$dialplan_entry = ereg_replace(";","",$dialplan_entry);
$dialplan_entry = ereg_replace("\r","",$dialplan_entry);
$custom_dialplan_entry = ereg_replace("\\\\","",$custom_dialplan_entry);
$custom_dialplan_entry = ereg_replace(";","",$custom_dialplan_entry);
$custom_dialplan_entry = ereg_replace("\r","",$custom_dialplan_entry);
$tts_text = ereg_replace("\\\\","",$tts_text);
$tts_text = ereg_replace(";","",$tts_text);
$tts_text = ereg_replace("\r","",$tts_text);
$tts_text = ereg_replace("\"","",$tts_text);
$carrier_description = ereg_replace("\\\\","",$carrier_description);
$carrier_description = ereg_replace(";","",$carrier_description);
$carrier_description = ereg_replace("\r","",$carrier_description);
$carrier_description = ereg_replace("\"","",$carrier_description);

$role_id=trim($_REQUEST["role_id"]);
$role_des=trim($_REQUEST["role_des"]);
$role_name=trim($_REQUEST["role_name"]);
$dept_id=trim($_REQUEST["dept_id"]);
$dept_name=trim($_REQUEST["dept_name"]);
$dept_des=trim($_REQUEST["dept_des"]);
$parent_id=trim($_REQUEST["parent_id"]);

$user_list=trim($_REQUEST["user_list"]);
$notice_id=trim($_REQUEST["notice_id"]);
$notice_title=trim($_REQUEST["notice_title"]);
$notice_des=trim($_REQUEST["notice_des"]);
$notice_content=trim($_REQUEST["notice_content"]);
$user_id=trim($_REQUEST["user_id"]);
$agent_name_list=trim($_REQUEST["agent_name_list"]);

$hangup_stop_rec=trim($_REQUEST["hangup_stop_rec"]);  
$display_dtmf_alter=trim($_REQUEST["display_dtmf_alter"]);
 
$dic_id=trim($_REQUEST["dic_id"]);
$dic_name=trim($_REQUEST["dic_name"]);
$dic_des=trim($_REQUEST["dic_des"]);
$dic_list_name=trim($_REQUEST["dic_list_name"]);
$dic_list_val=trim($_REQUEST["dic_list_val"]);
$dic_list_def=trim($_REQUEST["dic_list_def"]);

  
//话术脚本资料字段 
$script_list_ary=array("phone_number"=>"电话号码","title"=>"标题","first_name"=>"名字","middle_initial"=>"中间名","last_name"=>"姓氏","province"=>"省份","city"=>"城市","state"=>"地区","address1"=>"地址1","address2"=>"地址2","address3"=>"地址3","postal_code"=>"邮编","gender"=>"性别","date_of_birth"=>"生日","alt_phone"=>"备用电话","email"=>"邮箱","vendor_lead_code"=>"代理商ID","security_phrase"=>"安全密码","comments"=>"描述","user"=>"工号","fullname"=>"工号姓名");

//话术脚本资料字段替换
function re_script_info($info,$lang="EN"){
	
	global $script_list_ary;
	$field_n_a=array();
	$field_v_a=array();
   	 
	foreach($script_list_ary as $field_v=>$field_n){
		array_push($field_n_a,"--A--".$field_n."--B--");
		array_push($field_v_a,"--A--".$field_v."--B--");
  	}
	if($lang=="CH"){
		$info=str_replace($field_v_a,$field_n_a,$info);
	}else{
		$info=str_replace($field_n_a,$field_v_a,$info);
	}
	$info=str_replace('src="/','src="http://'.$_SERVER["HTTP_HOST"].'/',$info);
	
 	return $info;
	
	unset($field_n_a);
	unset($field_v_a);
	
}


?>