<?php 

namespace Kenjiefx\Scribe\Interfaces;
use Kenjiefx\Scribe\Git\TreeIterator;
use Kenjiefx\Scribe\Git\ReferenceIterator;
use Kenjiefx\Scribe\Git\GitCommit;
use Kenjiefx\Scribe\Release;
use Kenjiefx\Scribe\Repository;

/**
 * The RemoteHostInterface defines a contract for interacting with a remote Git host. 
 * The interface abstracts the details of communication with the remote Git host, 
 * allowing implementations to provide the necessary functionality to interact with remote repositories.
 */
interface RemoteHostInterface {

    /**
     * Returns the most recent release
     */
    public function getCurrentRelease(Repository $repository): Release;


    /**
     * Returns a URL that points to a certain release/version stored
     * in a remote host/server in an archived (zip) format. 
     */
    public function getReleaseByTag(Repository $repository, string $tagName): Release;

    /**
     * Returns the most recent commit to the main branch. 
     * @param Repository $repository - The repository object
     * @return GitCommit - A commit object
     */
    public function getMainBranchLatestCommit(Repository $repository): GitCommit;

    /**
     * Retrieves the references (branches, tags, etc.) in the repository.
     * @param Repository $repository - The repository object
     * @return ReferenceIterator - allows iteration over the references, providing access to information 
     * such as the name, target commit, and type of each reference in the repository.
     */
    public function getRefs(Repository $repository): ReferenceIterator;

    /**
     * Retrieves the tree (directory structure) of the specified commit, allowing iteration 
     * over the files and directories in that commit's tree.
     * @param Repository $repository - The repository object
     * @param GitCommit $commit - The Commit object
     * @return TreeIterator allows iteration over the files and directories in the main branch's tree, 
     * providing a way to navigate and inspect the contents of the repository's main branch.
     */
    public function getTree(Repository $repository, GitCommit $commit): TreeIterator;

}