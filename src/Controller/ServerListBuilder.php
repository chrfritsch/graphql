<?php

namespace Drupal\graphql\Controller;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;

class ServerListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    return [
      'label' => $this->t('Label'),
    ] + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    return [
      'label' => $entity->label(),
    ] + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultOperations(EntityInterface $entity) {
    $operations = parent::getDefaultOperations($entity);
    $id = $entity->id();

    if (\Drupal::currentUser()->hasPermission('use graphql explorer')) {
      $operations['explorer'] = [
        'title' => 'Explorer',
        'weight' => 10,
        'url' => Url::fromRoute("graphql.explorer.$id"),
      ];
    }

    if (\Drupal::currentUser()->hasPermission('use graphql voyager')) {
      $operations['voyager'] = [
        'title' => 'Voyager',
        'weight' => 10,
        'url' => Url::fromRoute("graphql.voyager.$id"),
      ];
    }

    return $operations;
  }

}
