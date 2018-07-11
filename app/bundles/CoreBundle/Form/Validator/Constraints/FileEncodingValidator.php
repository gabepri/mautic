<?php

/*
 * @copyright   2018 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\CoreBundle\Form\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Throws an exception if the field alias is equal some segment filter keyword.
 * It would cause odd behavior with segment filters otherwise.
 */
class FileEncodingValidator extends ConstraintValidator
{
    /**
     * @param LeadField  $field
     * @param Constraint $constraint
     */
    public function validate($field, Constraint $constraint)
    {
        if ($field->getPathname() != null) {
            if (!mb_check_encoding(file_get_contents($field->getPathname()), 'UTF-8')) {
                $this->context->addViolation($constraint->encodingFormatMessage, ['%keyword%' => $field->getClientOriginalName()]);
            }
        }
    }
}
