<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( !function_exists( 'crework_tribe_events_get_css' ) ) {
	add_filter( 'crework_filter_get_css', 'crework_tribe_events_get_css', 10, 4 );
	function crework_tribe_events_get_css($css, $colors, $fonts, $scheme='') {
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS
			
.tribe-events-list .tribe-events-list-event-title {
	{$fonts['h3_font-family']}
}
.tribe-events-calendar-month__header-column-title.tribe-common-b3,
.tribe-common .tribe-common-b3,
.tribe-events .tribe-events-c-ical__link,
.tribe-common .tribe-common-c-btn-border, 
.tribe-common a.tribe-common-c-btn-border,
body .tribe-events .tribe-events-c-top-bar__datepicker-button,
.tribe-common .tribe-common-c-btn,
.tribe-events .tribe-events-c-view-selector__list-item-text,
#tribe-events .tribe-events-button,
.tribe-events-button,
.tribe-events-cal-links a,
.tribe-events-sub-nav li a {
	{$fonts['button_font-family']}
	{$fonts['button_font-size']}
	{$fonts['button_font-weight']}
	{$fonts['button_font-style']}
	{$fonts['button_line-height']}
	{$fonts['button_text-decoration']}
	{$fonts['button_text-transform']}
	{$fonts['button_letter-spacing']}
}
.tribe-common .tribe-common-c-btn-border-small, .tribe-common a.tribe-common-c-btn-border-small,
#tribe-bar-form button, #tribe-bar-form a,
.tribe-events-read-more {
	{$fonts['button_font-family']}
	{$fonts['button_letter-spacing']}
}
#tribe-bar-views .tribe-bar-views-list a,
#tribe-bar-views .tribe-bar-views-toggle{
	{$fonts['input_font-family']}
}
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title,
.tribe-events-calendar td div[id*="tribe-events-daynum-"],
#tribe-bar-form label,
.tribe-events-list .tribe-events-list-separator-month,
.tribe-events-calendar thead th,
.tribe-events-schedule, .tribe-events-schedule h2 {
	{$fonts['h5_font-family']}
}
#tribe-events-content.tribe-events-month,
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title,
#tribe-mobile-container .type-tribe_events,
.tribe-events-list-widget ol li .tribe-event-title {
	{$fonts['p_font-family']}
}
.tribe-events-loop .tribe-event-schedule-details,
.single-tribe_events #tribe-events-content .tribe-events-event-meta dt,
#tribe-mobile-container .type-tribe_events .tribe-event-date-start {
	{$fonts['info_font-family']};
}

.tribe-common .tribe-events-calendar-month__day-date-daynum,
.tribe-common .tribe-events-calendar-month__multiday-event-bar-title,
.tribe-common--breakpoint-medium.tribe-common .tribe-common-form-control-text__input,
.tribe-common .tribe-common-h7,
.tribe-events .tribe-events-calendar-list__event-date-tag-weekday,
.tribe-common .tribe-events-calendar-month__calendar-event-tooltip-title.tribe-common-h7,
.tribe-common .tribe-events-calendar-day__event-title.tribe-common-h6,
.tribe-common .tribe-events-calendar-list__event .tribe-common-h6,
.tribe-common .tribe-events-calendar-month__header-row .tribe-common-b3,
#tribe-bar-form label {
	{$fonts['h5_font-family']}
}

.tribe-events .tribe-events-calendar-month__calendar-event-tooltip-datetime,
.tribe-common .tribe-common-h5,
.tribe-common .tribe-events-calendar-day__event-header .tribe-common-b2,
.tribe-common .tribe-events-calendar-list__event .tribe-common-b2{
    {$fonts['p_font-family']}
}

CSS;

			
			$rad = crework_get_border_radius();
			$css['fonts'] .= <<<CSS


CSS;
		}


		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

/* Filters bar */
#tribe-bar-form {
	color: {$colors['text_dark']};
}
#tribe-bar-form input[type="text"] {
	color: {$colors['input_text']};
	border-color: {$colors['input_bd_color']};
}
#tribe-bar-form input[type="text"]:hover,
#tribe-bar-form input[type="text"]:focus {
	border-color: {$colors['input_bd_hover']};
}
.tribe-bar-views-list {
	
}

.datepicker thead tr:first-child th:hover, .datepicker tfoot tr th:hover {
	color: {$colors['text_link']};
	background: {$colors['text_dark']};
}

/* Content */
.tribe-events-calendar thead th {
	color: {$colors['text_dark']};
	background: transparent !important;
	border-color: transparent !important;
}
.tribe-events-calendar thead th + th:before {
	background: {$colors['bg_color']};
}
#tribe-events-content {
	border-color: {$colors['bd_color']};
}
#tribe-events-content .tribe-events-calendar td {
	border-color: {$colors['bd_color']} !important;
}
.tribe-events-calendar td div[id*="tribe-events-daynum-"],
.tribe-events-calendar td div[id*="tribe-events-daynum-"] > a {
	color: {$colors['text_link2']};
}
.tribe-events-calendar td.tribe-events-othermonth {
	color: {$colors['alter_light']};
	background: {$colors['alter_bg_hover']} !important;
}
.tribe-events-calendar td.tribe-events-othermonth:hover {
	background: {$colors['text_link3']} !important;
}
.tribe-events-calendar td.tribe-events-othermonth div[id*="tribe-events-daynum-"],
.tribe-events-calendar td.tribe-events-othermonth div[id*="tribe-events-daynum-"] > a {
	color: {$colors['alter_light']};
}
.tribe-events-calendar td.tribe-events-past div[id*="tribe-events-daynum-"], .tribe-events-calendar td.tribe-events-past div[id*="tribe-events-daynum-"] > a {
	color: {$colors['text_light']};
}
.tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"],
.tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"] > a {
	color: {$colors['text_link']};
}
.tribe-events-calendar td.tribe-events-present {
	background-color: {$colors['text_link3']};
}
.tribe-events-calendar td.tribe-events-present:before {
	border-color: {$colors['text_link3']};
}
.tribe-events-calendar td.tribe-events-present  div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a{
	color: {$colors['inverse_link']} !important;
}
.tribe-events-calendar td.tribe-events-present  div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a:hover{
	color: {$colors['text_link']} !important;
}
.tribe-events-calendar .tribe-events-has-events:after {
	background-color: {$colors['text']};
}
.tribe-events-calendar .mobile-active.tribe-events-has-events:after {
	background-color: {$colors['bg_color']};
}
#tribe-events-content .tribe-events-calendar td,
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a {
	color: {$colors['text_dark']};
}
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a:hover {
	color: {$colors['text_link']};
}
#tribe-events-content .tribe-events-calendar td.mobile-active,
#tribe-events-content .tribe-events-calendar td.mobile-active:hover {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_dark']};
}
#tribe-events-content .tribe-events-calendar td.mobile-active div[id*="tribe-events-daynum-"] {
	color: {$colors['bg_color']};
	background-color: {$colors['text_dark']};
}
#tribe-events-content .tribe-events-calendar td.tribe-events-othermonth.mobile-active div[id*="tribe-events-daynum-"] a,
.tribe-events-calendar .mobile-active div[id*="tribe-events-daynum-"] a {
	background-color: transparent;
	color: {$colors['bg_color']};
}

.events-archive.events-gridview #tribe-events-content table .type-tribe_events + .type-tribe_events .tribe-events-month-event-title{
	border-color: {$colors['bd_color']};
}

#tribe-events-content .tribe-events-calendar td:hover {
	background: {$colors['text_link3']};
}

#tribe-events-content .tribe-events-calendar td:hover div[id*="tribe-events-daynum-"], 
#tribe-events-content .tribe-events-calendar td:hover div[id*="tribe-events-daynum-"]>a {
	color: {$colors['text_link']};
}

#tribe-events-content .tribe-events-calendar td:hover div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a {
	color: {$colors['inverse_text']};
}
#tribe-events-content .tribe-events-calendar td:hover div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a:hover {
	color: {$colors['text_link']};
}

/* Tooltip */
.recurring-info-tooltip,
.tribe-events-calendar .tribe-events-tooltip,
.tribe-events-week .tribe-events-tooltip,
.tribe-events-tooltip .tribe-events-arrow {
	color: {$colors['alter_text']};
	background: {$colors['alter_bg_color']};
}
#tribe-events-content .tribe-events-tooltip h3 { 
	color: {$colors['inverse_text']};
	background: {$colors['text_dark']};
}
.tribe-events-tooltip .tribe-event-duration {
	color: {$colors['text_light']};
}

/* Events list */
.tribe-events-list-separator-month {
	color: {$colors['text_dark']};
}
.tribe-events-list-separator-month:after {
	border-color: {$colors['bd_color']};
}
.tribe-events-list .type-tribe_events + .type-tribe_events,
.tribe-events-day .tribe-events-day-time-slot + .tribe-events-day-time-slot + .tribe-events-day-time-slot {
	border-color: {$colors['bd_color']};
}
.tribe-events-list .tribe-events-event-cost span {
	color: {$colors['bg_color']};
	border-color: {$colors['text_dark']};
	background: {$colors['text_dark']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta {
	color: {$colors['alter_text']};
	border-color: {$colors['alter_bd_color']};
	background-color: {$colors['alter_bg_color']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta a {
	color: {$colors['alter_link']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta a:hover {
	color: {$colors['alter_hover']};
}
.tribe-mobile .tribe-events-list .tribe-events-venue-details {
	border-color: {$colors['alter_bd_color']};
}

/* Events day */
.tribe-events-day .tribe-events-day-time-slot h5 {
	color: {$colors['bg_color']};
	background: {$colors['text_dark']};
}

/* Single Event */
.single-tribe_events .tribe-events-venue-map {
	color: {$colors['alter_text']};
	border-color: {$colors['alter_bd_hover']};
	background: {$colors['alter_bg_hover']};
}
.single-tribe_events .tribe-events-schedule .tribe-events-cost {
	color: {$colors['text_dark']};
}
.single-tribe_events .type-tribe_events {
	border-color: {$colors['bd_color']};
}

#tribe-bar-views .tribe-bar-views-list .tribe-bar-views-option a,
.tribe-bar-mini #tribe-bar-views .tribe-bar-views-list .tribe-bar-views-option a,
#tribe-bar-views .tribe-bar-views-toggle{
	color: {$colors['input_light']};
	background: {$colors['bg_color']};
}
#tribe-bar-views .tribe-bar-views-list .tribe-bar-views-option a:hover {
	color: {$colors['text_dark']};
	background: {$colors['bg_color']};
}

#tribe-bar-views .tribe-bar-views-option.tribe-bar-active {
	border-color: {$colors['input_bd_color']};
}
#tribe-bar-views .tribe-bar-views-option.tribe-bar-active:hover {
	border-color: {$colors['input_bd_hover']};
}
#tribe-bar-views .tribe-bar-views-option.tribe-bar-active:after {
	color: {$colors['input_light']};
}
#tribe-bar-views .tribe-bar-views-option.tribe-bar-active:hover::after {
	color: {$colors['text_dark']};
}
.tribe-events-sub-nav li.tribe-events-nav-next a,
.tribe-events-sub-nav li.tribe-events-nav-previous a {
    background-color: transparent !important;
	color: {$colors['text_dark']};
}
.tribe-events-sub-nav li.tribe-events-nav-next a:hover,
.tribe-events-sub-nav li.tribe-events-nav-previous a:hover {
    background-color: transparent !important;
	color: {$colors['text_link2']};
}

.tribe-events-calendar-month__calendar-event-tooltip-description.tribe-common-b3,
.tribe-common .tribe-events-calendar-day__event-description,
.tribe-common .tribe-events-calendar-list__event-description{
    color: {$colors['text']};
}

.tribe-events .tribe-events-calendar-month__day-cell--selected .tribe-events-calendar-month__day-date{
    color: {$colors['text_hover2']};
}
.tribe-events .tribe-events-calendar-month__day-cell--selected .tribe-events-calendar-month__mobile-events-icon--event{
     background-color: {$colors['text_hover2']};
}

CSS;
		}
		
		return $css;
	}
}
?>