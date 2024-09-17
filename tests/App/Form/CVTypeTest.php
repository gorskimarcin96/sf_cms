<?php

namespace App\Tests\Form;

use App\Form\CVType;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CVTypeTest extends TypeTestCase
{
    public function testBuildForm(): void
    {
        $formData = ['cv' => 'Sample CV content'];
        $form = $this->factory->create(CVType::class, null, ['cv' => $formData['cv']]);

        $this->assertTrue($form->has('cv'));

        $cvField = $form->get('cv');

        $this->assertSame(TextEditorType::class, get_class($cvField->getConfig()->getType()->getInnerType()));
        $this->assertSame($formData['cv'], $cvField->getData());
        $this->assertSame('w-100 h-100', $cvField->getConfig()->getOption('attr')['class']);
    }

    public function testConfigureOptions(): void
    {
        $resolver = new OptionsResolver();
        $formType = new CVType();
        $formType->configureOptions($resolver);

        $this->assertSame('', $resolver->resolve()['cv']);
    }
}
