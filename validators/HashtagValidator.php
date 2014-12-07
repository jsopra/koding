<?php
namespace app\validators;

use yii\validators\Validator;

/**
 * Validates #hastags according to this rule:
 * @see https://gist.github.com/janogarcia/3946583
 */
class HashtagValidator extends Validator
{
    /**
     * @var string user-defined error message hashtag is invalid
     */
    public $invalidHashtag;

    /**
     * @var string the regular expression for matching hashtags.
     * @see https://gist.github.com/janogarcia/3946583
     */
    public $hashtagPattern = '/^(?=.{2,140}$)(#|\x{ff03}){1}([0-9_\p{L}]*[_\p{L}][0-9_\p{L}]*)$/u';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (null === $this->invalidHashtag) {
            $this->invalidHashtag = '{attribute} is an invalid hashtag.';
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        if (preg_match($this->hashtagPattern, $value)) {
            return null;
        } else {
            return [$this->invalidHashtag, []];
        }
    }
}
