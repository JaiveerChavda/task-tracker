# TODO Task Tracker - PHP CLI Application

## Overview

#### Task tracker is a project used to track and manage your tasks.The application should run from the command line, accept user actions and inputs as arguments, and store the tasks in a JSON file. The user should be able to:

* Add, Update, and Delete tasks
* Mark a task as in progress or done
* List all tasks
* List all tasks that are done
* List all tasks that are not done
* List all tasks that are in progress

## prerequisites

* PHP 8.3

## Installation

**Follow these steps, to run this application locally on your machine.**

1. **Clone this repo**

    ```bash 
    git clone https://github.com:JaiveerChavda/task-tracker.git 
    ```

## Usage

> ⚠️ **Warning:** Make sure you run these commands in your project's root directory.

### Add a task

` php src/task-tracker.php list`

### Edit a task

` php src/task-tracker.php update <task-id> "<task-name>" `

### Delete a task

` php src/task-tracker.php delete <task-id>" `

### List all tasks

` php src/task-tracker.php list" `

### List completed tasks

` php src/task-tracker.php list done" `

### List in-progress tasks

` php src/task-tracker.php list in-progress" `


