<?php

namespace VolunteerManagementSystem\ReportGenerationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
Use VolunteerManagementSystem\ProjectBundle\Entity\Project;

class ProjectReportController extends Controller {

    public function ProjectReportAction(Request $request) {
        $projectId = $request->get('projectId');
        $em = $this->getDoctrine()->getEntityManager();
        $ProjectRepository = $em->getRepository('VolunteerManagementSystemProjectBundle:Project');

        $project = $ProjectRepository->findOneBy(array('id' => $projectId));

        $today_dt = new DateTime(date('Y-m-d'));
        $end_dt = new DateTime($project->getEnddate());

        if ($end_dt < $today_dt) { 
            $status = "Finished";
        }else{
            $status = "Ongoing";
        }    

        if ($project) {

            return $this->render('VolunteerManagementSystemReportGenerationBundle:ProjectReport:ProjectReport.html.twig', array('projectname' => $project->getName(), 'description' => $project->getDescription(), 'startdate' => $project->getStartdate(), 'enddate' => $project->getEnddate(), 'projectmanager' => $project->getProjectmanager(), 'objectives' => $project->getObjectives(), 'status' => $status));
        } else {
            return new Response('Project not found!!!');
        }
    }

}