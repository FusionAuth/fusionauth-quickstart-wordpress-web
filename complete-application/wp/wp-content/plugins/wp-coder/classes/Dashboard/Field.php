<?php

namespace WPCoder\Dashboard;

defined( 'ABSPATH' ) || exit;

class Field {

	public static function textarea( $name = '', $default = '' ): void {
		self::check_name( $name );
		$value = self::get_value( $name, $default );
		$id    = self::get_id( $name );
		$name  = self::get_name( $name );
		echo '<textarea name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '">' . esc_html( $value ) . '</textarea>';
	}

	public static function select( $name = '', $default = '', $options = [] ): void {
		self::check_name( $name );
		$value = self::get_value( $name, $default );
		$id    = self::get_id( $name );
		$name  = self::get_name( $name );
		echo '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '">';
		foreach ( $options as $key => $val ) {

			if ( strrpos( $key, '_start' ) ) {
				echo '<optgroup label="' . esc_attr( $val ) . '">';
			} elseif ( strrpos( $key, '_end' ) ) {
				echo '</optgroup>';
			} else {
				echo '<option value="' . esc_attr( $key ) . '"' . selected( $value, $key, false ) . '>' . esc_html( $val ) . '</option>';
			}
		}
		echo '</select>';
	}

	public static function text( $name = '', $default = '', $type = 'text' ): void {
		self::check_name( $name );
		$value = self::get_value( $name, $default );
		$id    = self::get_id( $name );
		$name  = self::get_name( $name );
		echo '<input type="' . esc_attr( $type ) . '" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . esc_attr( $value ) . '">';
	}

	public static function checkbox( $name = '' ): void {
		self::check_name( $name );
		$value = self::get_value( $name );
		$id    = self::get_id( $name );
		$name  = self::get_name( $name );
		echo '<input type="checkbox" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="1"' . checked( $value, "1", false ) . '>';
	}

	private static function get_name( $name ) {
		if ( strpos( $name, '[' ) !== false ) {
			return 'param' . $name;
		}

		return $name;
	}

	private static function get_value( $name, $defval = '' ) {

		$default = self::getDefault();

		if ( strpos( $name, '[' ) !== false ) {

			$value = self::get_param_value( 'param' . $name, $default );
			if ( ! isset( $value ) && ! empty( $defval ) ) {
				return $defval;
			}

			return $value;

		}

		if ( empty( $default[ $name ] ) && ! empty( $defval ) ) {
			return $defval;
		}

		return $default[ $name ];
	}

	private static function get_id( $name ) {
		return str_replace( array( '][', '[', ']' ), array( '_', '', '' ), $name );
	}

	private static function get_param_value( $name, $array ) {
		$keys  = preg_split( '/\[|\]/', $name, - 1, PREG_SPLIT_NO_EMPTY );
		$value = $array;

		foreach ( $keys as $key ) {
			if ( isset( $value[ $key ] ) ) {
				$value = $value[ $key ];
			} else {
				return null;
			}
		}

		return $value;
	}

	private static function check_name( $name ) {
		if ( empty( $name ) ) {
			wp_die( __( 'Field must have name', 'wpcoder' ) );
		}
	}

	public static function getDefault(): array {
		$id      = isset( $_REQUEST['id'] ) ? absint( $_REQUEST['id'] ) : 0;
		$columns = DBManager::get_columns();

		if ( empty( $id ) ) {
			return self::get_data();
		}

		$action = isset( $_REQUEST['action'] ) ? sanitize_text_field( $_REQUEST['action'] ) : 'update';
		$result = DBManager::get_data_by_id( $id );

		if ( $action === 'update' ) {

			return self::get_data( $result );
		}

		$data          = self::get_data( $result );
		$data['id']    = '';
		$data['title'] = '';

		return $data;
	}

	private static function get_data( $result = '' ): array {
		$columns = DBManager::get_columns();
		$data    = [];
		foreach ( $columns as $column ) {
			$name = $column->Field;
			if ( empty( $result ) ) {
				if ( $name === 'param' ) {
					$data[ $name ] = [];
					continue;
				}
				$data[ $name ] = '';
			} else {
				$val = ! empty( $result->$name ) ? $result->$name : '';
				if ( $name === 'param' ) {
					$data[ $name ] = maybe_unserialize( $val );
					continue;
				}
				$data[ $name ] = $val;
			}
		}

		return $data;
	}
}