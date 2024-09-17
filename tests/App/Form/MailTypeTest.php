<?php

namespace App\Tests\Form;

use App\Form\MailType;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Test\TypeTestCase;

class MailTypeTest extends TypeTestCase
{
    #[DataProvider('data')]
    public function testBuildFormFields(string $fieldName, string $fieldType, string $label, string $class): void
    {
        $form = $this->factory->create(MailType::class);

        $this->assertTrue($form->has($fieldName));

        $field = $form->get($fieldName);

        $this->assertSame($fieldType, get_class($field->getConfig()->getType()->getInnerType()));
        $this->assertSame($label, $field->getConfig()->getOption('label'));
        $this->assertSame($class, $field->getConfig()->getOption('attr')['class']);
    }

    /**
     * @return array<int, array<int, string>>
     */
    public static function data(): array
    {
        return [
            ['email', EmailType::class, 'E-mail', MailType::ATTR_CLASS],
            ['message', TextareaType::class, 'Message', MailType::ATTR_CLASS],
            ['number', NumberType::class, 'What is the result for 2 + 3?', MailType::ATTR_CLASS],
            ['submit', SubmitType::class, 'Send', 'btn btn-success ml-auto d-block'],
        ];
    }
}
