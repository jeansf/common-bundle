# CommonBundle

* AbstractEntity (createdAt,updatedAt,removedAt) - Entity
* TraitUserCreatedBy (createdBy) - Entity
* BeforeActionSubscriber (converte requisição JSON para Request)

>config/services.yml
>```
>parameters:
>   pix_common_user_entity: App\Entity\User
>```
>Utilizado para relacionamento com a entidade User
>
>Foi utilizado a configuração do doctrine `resolve_target_entities` em `config/doctrine.yaml` para resolver a interface `Symfony\Component\Security\Core\User\UserInterface` 
