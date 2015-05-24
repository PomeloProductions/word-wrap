<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 5/20/15
 * Time: 8:52 PM
 */

namespace WordWrap\AssetManager;

use \Exception;

class Asset {

    /**
     * @var string the location where our assets will be
     */
    protected $assetLocation;

    /**
     * @var string the file contents the asset contained
     */
    protected $assetContents;

    function __construct($assetLocation) {
        $this->$assetLocation = $assetLocation;

        $this->inflateAsset();
    }

    /**
     * loads the asset into memory from the file system
     * @throws Exception if the asset we are looking for is not found
     */
    protected function inflateAsset() {
        if(!file_exists($this->assetLocation ))
            throw new Exception("Unable to find asset at path " . $this->assetLocation);

        $this->assetContents = file_get_contents($this->assetLocation);
    }

    /**
     * This function will replace all of the values of this assets keys and return the result
     * @param $placeHolders string[] key values which we are going to replace the contents of
     * @return string the asset with all keys replaced
     */
    public function replacePlaceholders($placeHolders) {
        $processedContents = $this->assetContents;

        foreach($placeHolders as $key => $value)
            $processedContents = str_replace('{{' . $key . '}}', $value, $processedContents);

        return $processedContents;
    }

}