<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CategoryAdmin extends AbstractAdmin
{
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper->add('parent');
		$formMapper->add('name', 'text');
		$formMapper->add('description');
		$formMapper->add('photo');
	}

	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('parent')
			->add('name')
			->add('description')
		;
	}

	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->add('parent')
			->addIdentifier('name')
			->add('description')
		;
	}
}
