<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\ArticleTranslation;
use Doctrine\Common\Collections\Collection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id');
        yield CollectionField::new('translations')
            ->formatValue(fn (Collection $translations) => $this->parseTranslations($translations));
        yield ImageField::new('fileFn')->setBasePath(Article::getBasePath());
        yield AssociationField::new('user');
        yield DateTimeField::new('createdAt');
        yield DateTimeField::new('updatedAt');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::DELETE);
    }

    /** @param Collection<int, ArticleTranslation> $translations */
    private function parseTranslations(Collection $translations): string
    {
        $translations = array_map(fn (ArticleTranslation $entity): string => $this->translationTemplate($entity), $translations->toArray());

        return '<ul>'.implode('', $translations).'</ul>';
    }

    private function translationTemplate(ArticleTranslation $entity): string
    {
        return '<li><b>'.$entity->getLocale().'</b><ul><li><b>title</b>: '.$entity->getTitle().
            '</li><li><b>description</b>: '.$entity->getDescription().'</li></ul></li>';
    }
}
