<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * TikTok Events API helper for Quote Form plugins.
 *
 * Sends server-side Lead events to TikTok's Events API.
 *
 * IMPORTANT: For production, consider moving Pixel ID and Access Token
 * into wp-config.php or a secure settings screen, rather than hard-coding.
 */
class CQF_TikTok_Events {

	/**
	 * TikTok Events API endpoint.
	 */
	const API_ENDPOINT = 'https://business-api.tiktok.com/open_api/v1.3/event/track/';

	/**
	 * Send a Lead event to TikTok Events API.
	 *
	 * @param array $args {
	 *   @type string $event_id       Required unique event ID (should match browser pixel for dedup).
	 *   @type int    $event_time     Unix timestamp (defaults to now).
	 *   @type string $email          Plain email (will be hashed).
	 *   @type string $phone          Plain phone (will be hashed).
	 *   @type string $external_id    Optional external ID (will be hashed).
	 *   @type float  $value          Optional order/lead value.
	 *   @type string $currency       Optional currency (e.g. GBP).
	 *   @type string $content_id     Optional content ID.
	 *   @type string $content_type   Optional content type.
	 *   @type string $content_name   Optional content name.
	 *   @type string $url            Page URL where event happened.
	 *   @type string $ip             Visitor IP.
	 *   @type string $user_agent     Visitor User-Agent.
	 *   @type string $ttclid         Optional TikTok click ID.
	 *   @type string $ttp            Optional TikTok browser cookie.
	 * }
	 *
	 * @return void
	 */
	public static function send_lead( array $args ) {
		$pixel_id = defined( 'TIKTOK_PIXEL_ID' ) ? TIKTOK_PIXEL_ID : '';
		$token    = defined( 'TIKTOK_EVENTS_ACCESS_TOKEN' ) ? TIKTOK_EVENTS_ACCESS_TOKEN : '';

		if ( empty( $pixel_id ) || empty( $token ) ) {
			return;
		}

		$event_id   = isset( $args['event_id'] ) ? (string) $args['event_id'] : '';
		$event_time = isset( $args['event_time'] ) ? (int) $args['event_time'] : time();

		if ( '' === $event_id ) {
			return;
		}

		// Hash PII as per TikTok requirements (SHA-256, lowercased/trimmed).
		$email       = isset( $args['email'] ) ? sanitize_email( $args['email'] ) : '';
		$phone       = isset( $args['phone'] ) ? wp_strip_all_tags( $args['phone'] ) : '';
		$external_id = isset( $args['external_id'] ) ? wp_strip_all_tags( $args['external_id'] ) : '';

		$user       = array();
		$email_norm = strtolower( trim( $email ) );
		if ( ! empty( $email_norm ) ) {
			$user['email'] = array( hash( 'sha256', $email_norm ) );
		}

		$phone_norm = preg_replace( '/\s+/', '', $phone );
		if ( ! empty( $phone_norm ) ) {
			$user['phone'] = array( hash( 'sha256', $phone_norm ) );
		}

		$external_norm = strtolower( trim( $external_id ) );
		if ( ! empty( $external_norm ) ) {
			$user['external_id'] = array( hash( 'sha256', $external_norm ) );
		}

		// Optional network context.
		if ( ! empty( $args['ip'] ) ) {
			$user['ip'] = $args['ip'];
		}
		if ( ! empty( $args['user_agent'] ) ) {
			$user['user_agent'] = $args['user_agent'];
		}

		$context = array(
			'page' => array(
				'url' => isset( $args['url'] ) ? esc_url_raw( $args['url'] ) : home_url( '/' ),
			),
		);

		if ( ! empty( $args['ttclid'] ) ) {
			$context['ttclid'] = sanitize_text_field( $args['ttclid'] );
		}
		if ( ! empty( $args['ttp'] ) ) {
			$context['ttp'] = sanitize_text_field( $args['ttp'] );
		}

		// Properties / event payload. Omit value/currency when 0 to avoid TikTok "invalid value" error.
		$properties = array();

		$value = isset( $args['value'] ) ? (float) $args['value'] : 0;
		if ( $value > 0 ) {
			$properties['value'] = $value;
			if ( ! empty( $args['currency'] ) ) {
				$properties['currency'] = strtoupper( sanitize_text_field( $args['currency'] ) );
			}
		}

		$content = array();
		if ( ! empty( $args['content_id'] ) || ! empty( $args['content_type'] ) || ! empty( $args['content_name'] ) ) {
			$content[] = array(
				'content_id'   => isset( $args['content_id'] ) ? (string) $args['content_id'] : '',
				'content_type' => isset( $args['content_type'] ) ? (string) $args['content_type'] : '',
				'content_name' => isset( $args['content_name'] ) ? (string) $args['content_name'] : '',
			);
		}
		if ( ! empty( $content ) ) {
			$properties['contents'] = $content;
		}

		$event = array(
			'event'        => 'Lead',
			'event_time'   => $event_time,
			'event_source' => 'web',
			'event_id'     => $event_id,
			'context'      => $context,
			'properties'   => $properties,
			'user'         => $user,
			'pixel_code'   => $pixel_id,
		);

		$body = array(
			'event_source' => 'web',
			'event'        => $event,
		);

		$args_request = array(
			'headers' => array(
				'Content-Type'  => 'application/json',
				'Authorization' => 'Bearer ' . $token,
			),
			'body'    => wp_json_encode( $body ),
			'timeout' => 5,
		);

		$response = wp_remote_post( self::API_ENDPOINT, $args_request );

		if ( is_wp_error( $response ) ) {
			error_log( 'CQF TikTok Events API error: ' . $response->get_error_message() );
			return;
		}

		$code = wp_remote_retrieve_response_code( $response );
		if ( $code < 200 || $code >= 300 ) {
			error_log( 'CQF TikTok Events API HTTP ' . $code . ' response: ' . wp_remote_retrieve_body( $response ) );
		}
	}
}

