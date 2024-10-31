<?php
namespace Getresponse\Sdk\Operation\Model;

use Getresponse\Sdk\Client\Operation\BaseModel;

class TemplateColorVariantShort extends BaseModel
{
    /** @var string */
    private $templateColorId = self::FIELD_NOT_SET;

    /** @var string */
    private $name = self::FIELD_NOT_SET;

    /** @var string */
    private $colorHex = self::FIELD_NOT_SET;

    /** @var string */
    private $thumbnail = self::FIELD_NOT_SET;

    /** @var string */
    private $preview = self::FIELD_NOT_SET;

    /** @var string */
    private $href = self::FIELD_NOT_SET;


    /**
     * @param string $templateColorId
     * @param string $name
     * @param string $colorHex
     * @param string $preview
     * @param string $href
     */
    public function __construct($templateColorId, $name, $colorHex, $preview, $href)
    {
        $this->templateColorId = $templateColorId;
        $this->name = $name;
        $this->colorHex = $colorHex;
        $this->preview = $preview;
        $this->href = $href;
    }


    /**
     * @param string $thumbnail
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }


        public function jsonSerialize(): array
    {
        $data = [
            'templateColorId' => $this->templateColorId,
            'name' => $this->name,
            'colorHex' => $this->colorHex,
            'thumbnail' => $this->thumbnail,
            'preview' => $this->preview,
            'href' => $this->href,
        ];

        return $this->filterUnsetFields($data);
    }
}
