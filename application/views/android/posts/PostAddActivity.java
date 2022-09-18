
public class PostAddActivity extends AppCompatActivity {
	
	private text post_title;
				private text post_summary;
				private text post_detail;
				private EditText post_type;
				private EditText image;
				private EditText video_link;
				private text post_keywords;
				private Button btn_add_posts;
	
	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.activity_add_post);
		
		post_title = (text)findViewById(R.id.post_title);
				post_summary = (text)findViewById(R.id.post_summary);
				post_detail = (text)findViewById(R.id.post_detail);
				post_type = (EditText)findViewById(R.id.post_type);
				image = (EditText)findViewById(R.id.image);
				video_link = (EditText)findViewById(R.id.video_link);
				post_keywords = (text)findViewById(R.id.post_keywords);
				btn_add_posts = (Button)findViewById(R.id.btn_add_posts);
		
		
btn_add_posts.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                //do your code here
				final String form_post_title = post_title.getText().toString();
				final String form_post_summary = post_summary.getText().toString();
				final String form_post_detail = post_detail.getText().toString();
				final String form_post_type = post_type.getText().toString();
				final String form_image = image.getText().toString();
				final String form_video_link = video_link.getText().toString();
				final String form_post_keywords = post_keywords.getText().toString();
				
				
				RequestQueue request_queue = Volley.newRequestQueue(PostAddActivity.this); 
				 StringRequest request = new StringRequest(Request.Method.POST, SERVER_URL+"/mobile/post/save_data", new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								Toast.makeText(PostAddActivity.this, server_response, Toast.LENGTH_SHORT).show();
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(PostAddActivity.this, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									params.put("post_title", form_post_title);
				params.put("post_summary", form_post_summary);
				params.put("post_detail", form_post_detail);
				params.put("post_type", form_post_type);
				params.put("image", form_image);
				params.put("video_link", form_video_link);
				params.put("post_keywords", form_post_keywords);
				
									return params;
								}
							};
							
				 request_queue.add(request);
				
				
            }
        });
//end here .....
		
		

     }

}
