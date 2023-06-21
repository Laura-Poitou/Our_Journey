<?php

namespace App\Service;

use App\Entity\Tip;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Manage user like
 */
class LikeManager
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    
    /**
     * Get all liked tips
     * 
     * @return Tip[] list of liked tips
     */
    public function list(): array
    {
        return $this->requestStack->getSession()->get('liked', []);
    }

    /**
     * Adds or removes a given tip to list of liked ones
     * 
     * @param Tip $tip The tip to toggle
     * @return bool true if added
     */
    public function toggle(Tip $tip): ?bool
    {
        // Retrieve list of liked tips in session
        // if session do not have liked tip -> return empty array
        $liked = $this->requestStack->getSession()->get('liked', []);

        // if the id of the tip is in array index
        if (array_key_exists($tip->getId(), $liked)) {
            // deleted presents tip
            unset($liked[$tip->getId()]);
            // return value
            $added = false;
        } else {

            // Added tip id to the list of liked ones
            $liked[$tip->getId()] = $tip;
            // valeur de retour
            $added = true;
        }

        // change 'liked' field value in session
        $this->requestStack->getSession()->set('liked', $liked);
        
        // we could return false if the tip already exists
        return $added;
    }

    /**
     * Empty liked
     */
    public function empty()
    {
        $this->requestStack->getSession()->remove('liked');
    }
}