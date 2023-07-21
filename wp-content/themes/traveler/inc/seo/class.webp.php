<?php 
class GDWebPConverter {

    private $file_path;
    private $file_dirname;
    private $file_ext;
    private $file_name_no_ext;

    private $array_of_sizes_to_be_converted = array();
    private $array_of_sizes_to_be_deleted   = array();

    public function __construct( $attachment_id ) {

        $this->file_path = get_attached_file( $attachment_id );
      
        $this->file_dirname = pathinfo( $this->file_path, PATHINFO_DIRNAME );
       

        $this->file_ext = strtolower( pathinfo( $this->file_path, PATHINFO_EXTENSION ) );
    
        $this->file_name_no_ext = pathinfo( $this->file_path, PATHINFO_FILENAME );
       
    }

    public function check_file_exists( $attachment_id ) {

        $file = get_attached_file( $attachment_id );

        if ( ! file_exists( $file ) ) {
            $message = 'The uploaded file does not exist on the server. Encoding not possible.';
           
            throw new Exception( 'The uploaded file does exist on the server. Encoding not possible.', 1 );
        }

    }

    public function check_mime_type() {

    
        $finfo = finfo_open( FILEINFO_MIME_TYPE );

        $this->file_mime_type = finfo_file( $finfo, $this->file_path );

        finfo_close( $finfo );
    
        $this->allowed_mime_type = array( 'image/jpeg', 'image/png' );

        if ( ! in_array( $this->file_mime_type, $this->allowed_mime_type, true ) ) {

            $message = 'MIME type of file not supported';

            throw new Exception( 'MIME type of file not supported', 1 );

        }
    }

    public function create_array_of_sizes_to_be_converted( $metadata ) {

    
        array_push( $this->array_of_sizes_to_be_converted, $this->file_path );
        
        foreach ( $metadata['sizes'] as $value ) {
        
            array_push( $this->array_of_sizes_to_be_converted, $this->file_dirname . '/' . $value['file'] );
        }
    
    }

    public function convert_array_of_sizes() {

       
        switch ( $this->file_ext ) {
            case 'jpeg':
            case 'jpg':
            foreach ( $this->array_of_sizes_to_be_converted as $key => $value ) {
                $image = imagecreatefromjpeg( $value );

                if ( 0 === $key ) {
                    imagewebp( $image, $this->file_dirname . '/' . $this->file_name_no_ext . '.webp', 80 );
                } else {

                    $current_size = getimagesize( $value );
                    imagewebp( $image, $this->file_dirname . '/' . $this->file_name_no_ext . '-' . $current_size[0] . 'x' . $current_size[1] . '.webp', 80 );

                }
                    imagedestroy( $image );
            }
            break;

            case 'png':
                foreach ( $this->array_of_sizes_to_be_converted as $key => $value ) {

                    $image = imagecreatefrompng( $value );
                    imagepalettetotruecolor( $image );
                    imagealphablending( $image, true );
                    imagesavealpha( $image, true );

                    if ( 0 === $key ) {

                        imagewebp( $image, $this->file_dirname . '/' . $this->file_name_no_ext . '.webp', 80 );

                    } else {

                        $current_size = getimagesize( $value );
                        imagewebp( $image, $this->file_dirname . '/' . $this->file_name_no_ext . '-' . $current_size[0] . 'x' . $current_size[1] . '.webp', 80 );

                    }

                    imagedestroy( $image );

                }
                break;

            default:
            return false;
        }

    }

    public function create_array_of_sizes_to_be_deleted( $attachment_id ) {

        $this->attachment_metadata_of_file_to_be_deleted = wp_get_attachment_metadata( $attachment_id );
        array_push( $this->array_of_sizes_to_be_deleted, $this->file_dirname . '/' . $this->file_name_no_ext . '.webp' );
        foreach ( $this->attachment_metadata_of_file_to_be_deleted['sizes'] as $value ) {

            $this->value_file_name_no_ext = pathinfo( $value['file'], PATHINFO_FILENAME );
            array_push( $this->array_of_sizes_to_be_deleted, $this->file_dirname . '/' . $this->value_file_name_no_ext . '.webp' );
        }
    }

    public function delete_array_of_sizes() {

        foreach ( $this->array_of_sizes_to_be_deleted as $key => $value ) {
            unlink( $value );
        }
    }

}
?>